<?php

namespace App\Repositories\Ingredient;

use App\Models\Ingredient;
use App\Exceptions\CustomException;


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
        $ingredient = Ingredient::find($id);
        if (!$ingredient) {
            throw new CustomException('Ingredient not found.', 404);
        }

        return $ingredient;
    }

    public function update($id, array $data)
    {
        $ingredient = Ingredient::find($id);
        if (!$ingredient) {
            throw new CustomException('Ingredient not found.', 404);
        }

        $ingredient->update($data);

        return $ingredient;
    }

    public function destroy($id)
    {
        $ingredient = Ingredient::find($id);
        if (!$ingredient) {
            throw new CustomException('Ingredient not found.', 404);
        }
        $ingredient->delete();

        return $ingredient;
    }
}