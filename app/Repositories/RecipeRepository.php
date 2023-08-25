<?php

namespace App\Repositories;

use App\Models\Recipe;

class RecipeRepository implements RecipeRepositoryInterface
{
    public function all()
    {
        return Recipe::all();
    }

    public function create(array $data)
    {
        return Recipe::create($data);
    }

    public function show($id)
    {
        return Recipe::findOrFail($id);
    }

    public function update($id, array $data)
    {
        $recipe = Recipe::findOrFail($id);
        $recipe->update($data);

        return $recipe;
    }

    public function destroy($id)
    {
        $recipe = Recipe::findOrFail($id);
        $recipe->delete();

        return $recipe;
    }
}