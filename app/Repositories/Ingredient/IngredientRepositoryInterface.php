<?php

namespace App\Repositories\Ingredient;

interface IngredientRepositoryInterface
{
    public function all();
    public function create(array $data);
    public function find($id);
    public function update($id, array $data);
    public function destroy($id);
}