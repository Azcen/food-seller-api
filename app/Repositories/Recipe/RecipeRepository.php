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

    public function show($id)
    {
        return Recipe::findOrFail($id);
    }

    public function update($id, array $data, array $ingredientsData)
    {
        $recipe = Recipe::findOrFail($id);
        $recipe->update($data);
        $this->syncIngredients($recipe, $ingredientsData);

        return $recipe;
    }

    public function destroy($id)
    {
        $recipe = Recipe::findOrFail($id);
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