<?php

namespace App\Repositories;

interface RecipeRepositoryInterface
{
    public function all();
    public function create(array $data);
    public function show($id);
    public function update($id, array $data);
    public function destroy($id);
}