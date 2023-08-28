<?php

namespace App\Services;

use App\Repositories\Ingredient\IngredientRepositoryInterface;

class IngredientService
{
    protected $ingredientRepository;

    public function __construct(IngredientRepositoryInterface $ingredientRepository)
    {
        $this->ingredientRepository = $ingredientRepository;
    }

    public function handleGetIngredients()
    {
        return $this->ingredientRepository->all();
    }

    public function handleCreateIngredient(array $data)
    {
        return $this->ingredientRepository->create($data);
    }

    public function handleGetIngredient($id)
    {
        return $this->ingredientRepository->find($id);
    }

    public function handleUpdateIngredient($id, array $data)
    {
        return $this->ingredientRepository->update($id, $data);
    }

    public function handleDestroyIngredient($id)
    {
        return $this->ingredientRepository->destroy($id);
    }
}