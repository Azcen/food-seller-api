<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\IngredientService;
use App\Http\Requests\IngredientRequest;

class IngredientController extends Controller
{
    protected $ingredientService;

    public function __construct(IngredientService $ingredientService)
    {
        $this->ingredientService = $ingredientService;
    }

    public function index()
    {
        $ingredients = $this->ingredientService->handleGetIngredients();
        return response()->json($ingredients);
    }

    public function store(IngredientRequest $request)
    {
        $data = $request->validated();
        $ingredient = $this->ingredientService->handleCreateIngredient($data);

        return response()->json($ingredient, 201);
    }

    public function show($id)
    {
        $ingredient = $this->ingredientService->handleGetIngredient($id);
        return response()->json($ingredient);
    }

    public function update(IngredientRequest $request, $id)
    {
        $data = $request->validated();
        $ingredient = $this->ingredientService->handleUpdateIngredient($id, $data);

        return response()->json($ingredient);
    }

    public function destroy($id)
    {
        $this->ingredientService->handleDestroyIngredient($id);

        return response()->json(['message' => 'Ingredient deleted']);
    }
}
