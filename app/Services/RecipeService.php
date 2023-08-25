<?php

namespace App\Services;

use App\Repositories\RecipeRepositoryInterface;

class RecipeService
{
    protected $recipeRepository;

    public function __construct(RecipeRepositoryInterface $recipeRepository)
    {
        $this->recipeRepository = $recipeRepository;
    }

    public function handleGetRecipes()
    {
        return $this->recipeRepository->all();
    }

    public function handleCreateRecipe(array $data)
    {
        return $this->recipeRepository->create($data);
    }

    public function handleGetRecipe($id)
    {
        return $this->recipeRepository->show($id);
    }

    public function handleUpdateRecipe($id, array $data)
    {
        return $this->recipeRepository->update($id, $data);
    }

    public function handleDestroyRecipe($id)
    {
        return $this->recipeRepository->destroy($id);
    }
}