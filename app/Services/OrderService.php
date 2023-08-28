<?php

namespace App\Services;

use App\Models\Order;
use App\Repositories\Order\OrderRepositoryInterface;
use App\Repositories\Ingredient\IngredientRepositoryInterface;
use App\Repositories\Recipe\RecipeRepositoryInterface;

class OrderService
{

    protected $orderRepository;
    protected $ingredientRepository;
    protected $recipeRepository;

    public function __construct(
        OrderRepositoryInterface $orderRepository, 
        IngredientRepositoryInterface $ingredientRepository,
        RecipeRepositoryInterface $recipeRepository
    )
    {
        $this->orderRepository = $orderRepository;
        $this->ingredientRepository = $ingredientRepository;
        $this->recipeRepository = $recipeRepository;
    }

    public function handleGetOrders()
    {
        $orders = $this->orderRepository->all();
        return $orders->map(function ($order) {
            return $this->formatOrderData($order);
        });
    }

    public function handleCreateOrder(array $data)
    {
        $details = $data['details'] ?? [];
        unset($data['details']);
        $order =  $this->orderRepository->create($data, $details);
        $this->updateIngredientsStock($details);
        return [
            'id' => $order->id,
            'client_name' => $order->client_name,
            'status' => $order->status,
            'details' => $this->formatDetails($order->orderDetails),
        ];
    }

    public function handleGetOrder($id)
    {
        $order =  $this->orderRepository->find($id);
        return [
            'id' => $order->id,
            'client_name' => $order->client_name,
            'status' => $order->status,
            'details' => $this->formatDetails($order->orderDetails),
        ];
    }

    public function handleUpdateOrder($id, array $data)
    {
        return $this->orderRepository->update($id, $data);
    }

    public function handleDestroyOrder($id)
    {
        return $this->orderRepository->delete($id);
    }

    protected function formatOrderData($order)
    {
        return [
            'id' => $order->id,
            'client_name' => $order->client_name,
            'status' => $order->status,
            'details' => $this->formatDetails($order->orderDetails),
        ];
    }

    protected function formatDetails($details)
    {
        return $details->map(function ($detail) {
            return [
                'id' => $detail->id,
                'quantity' => $detail->quantity,
                'recipe' => $detail->recipe,
                'comments' => $detail->comments,
            ];
        });
    }

    protected function updateIngredientsStock(array $orderDetails)
    {
        foreach ($orderDetails as $detail) {
            $recipeId = $detail['recipe_id'];
            $quantityOrdered = $detail['quantity'];

            $recipe = $this->recipeRepository->find($recipeId);
            $ingredients = $recipe->ingredients;

            foreach ($ingredients as $ingredient) {
                $pivotData = $ingredient->pivot;
                $quantityPerRecipe = $pivotData->quantity;
                $ingredientId = $pivotData->ingredient_id;

                $quantityToDeduct = $quantityOrdered * $quantityPerRecipe;

                $this->updateIngredientStock($ingredientId, $quantityToDeduct);
            }
        }
    }

    protected function updateIngredientStock($ingredientId, $quantity)
    {
        $ingredient = $this->ingredientRepository->find($ingredientId);

        $newQuantity = $ingredient->quantity - $quantity;

        if ($newQuantity < 0) {
            $newQuantity = 0; 
        }

        $this->ingredientRepository->update($ingredientId, ['quantity' => $newQuantity]);
    }
}