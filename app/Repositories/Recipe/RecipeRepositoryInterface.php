<?php

namespace App\Repositories\Recipe;

interface RecipeRepositoryInterface
{
    public function all();
    public function create(array $data, array $ingredientsData);
    public function show($id);
    public function update($id, array $data, array $ingredientsData);
    public function destroy($id);
}