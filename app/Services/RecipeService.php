<?php

namespace App\Services;

use App\Repositories\Recipe\RecipeRepositoryInterface;

class RecipeService
{
    protected $recipeRepository;

    public function __construct(RecipeRepositoryInterface $recipeRepository)
    {
        $this->recipeRepository = $recipeRepository;
    }

    public function handleGetRecipes()
    {
        $recipes = $this->recipeRepository->all();
        return $recipes->map(function ($recipe) {
            return $this->formatRecipeData($recipe);
        });
    }

    public function handleCreateRecipe(array $data)
    {
        $ingredientsData = $data['ingredients'] ?? [];
        unset($data['ingredients']);
        $recipe = $this->recipeRepository->create($data, $ingredientsData);
        return $this->formatRecipeData($recipe);
    }

    public function handleGetRecipe($id)
    {
        $recipe = $this->recipeRepository->find($id);
        return $this->formatRecipeData($recipe);
    }

    public function handleUpdateRecipe($id, array $data)
    {
        $ingredientsData = $data['ingredients'] ?? [];
        $recipe = $this->recipeRepository->update($id, $data, $ingredientsData);
        return $this->formatRecipeData($recipe);
    }

    public function handleDestroyRecipe($id)
    {
        return $this->recipeRepository->destroy($id);
    }

    protected function formatIngredients($ingredients)
    {
        return $ingredients->map(function ($ingredient) {
            return [
                'id' => $ingredient->id,
                'name' => $ingredient->name,
                'quantity' => $ingredient->pivot->quantity,
            ];
        });
    }

    protected function formatRecipeData($recipe)
    {
        return [
            'id' => $recipe->id,
            'name' => $recipe->name,
            'type' => $recipe->type,
            'price' => $recipe->price,
            'description' => $recipe->description,
            'ingredients' => $this->formatIngredients($recipe->ingredients),
        ];
    }
}