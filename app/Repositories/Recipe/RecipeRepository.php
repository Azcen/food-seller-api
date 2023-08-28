<?php

namespace App\Repositories\Recipe;

use App\Models\Recipe;

class RecipeRepository implements RecipeRepositoryInterface
{
    public function all()
    {
        return Recipe::all();
    }

    public function create(array $data, array $ingredientsData)
    {
        $recipe = Recipe::create($data);
        $this->syncIngredients($recipe, $ingredientsData);
        return $recipe;
    }

    public function find($id)
    {
        $recipe = Recipe::find($id);
        if (!$recipe) {
            throw new CustomException('Recipe not found.', 404);
        }

        return $recipe;
    }

    public function update($id, array $data, array $ingredientsData)
    {
        $recipe = Recipe::find($id);
        if (!$recipe) {
            throw new CustomException('Recipe not found.', 404);
        }

        $recipe->update($data);
        $this->syncIngredients($recipe, $ingredientsData);

        return $recipe;
    }

    public function destroy($id)
    {
        $recipe = Recipe::find($id);
        if (!$recipe) {
            throw new CustomException('Recipe not found.', 404);
        }
        $recipe->delete();

        return $recipe;
    }

    protected function syncIngredients(Recipe $recipe, $ingredientsData)
    {
        $pivotData = [];

        foreach ($ingredientsData as $ingredientData) {
            $ingredientId = $ingredientData['id'];
            $quantity = $ingredientData['quantity'];
            $pivotData[$ingredientId] = ['quantity' => $quantity];
        }

        $recipe->ingredients()->sync($pivotData);
    }
}