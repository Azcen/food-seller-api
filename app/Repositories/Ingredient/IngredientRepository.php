<?php

namespace App\Repositories\Ingredient;

use App\Models\Ingredient;

class IngredientRepository implements IngredientRepositoryInterface
{
    public function all()
    {
        return Ingredient::all();
    }

    public function create(array $data)
    {
        return Ingredient::create($data);
    }

    public function show($id)
    {
        return Ingredient::findOrFail($id);
    }

    public function update($id, array $data)
    {
        $ingredient = Ingredient::findOrFail($id);
        $ingredient->update($data);

        return $ingredient;
    }

    public function destroy($id)
    {
        $ingredient = Ingredient::findOrFail($id);
        $ingredient->delete();

        return $ingredient;
    }
}