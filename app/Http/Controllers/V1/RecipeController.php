<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\RecipeRequest;
use App\Services\RecipeService;

class RecipeController extends Controller
{
    protected $recipeService;

    public function __construct(RecipeService $recipeService)
    {
        $this->recipeService = $recipeService;
    }

    public function index()
    {
        $recipes = $this->recipeService->handleGetRecipes();
        return response()->json($recipes);
    }

    public function store(RecipeRequest $request)
    {
        $data = $request->validated();
        $recipe = $this->recipeService->handleCreateRecipe($data);

        return response()->json($recipe, 201);
    }

    public function show($id)
    {
        $recipe = $this->recipeService->handleGetRecipe($id);
        return response()->json($recipe);
    }

    public function update(RecipeRequest $request, $id)
    {
        $data = $request->validated();
        $recipe = $this->recipeService->handleUpdateRecipe($id, $data);

        return response()->json($recipe);
    }

    public function destroy($id)
    {
        $this->recipeService->handleDestroyRecipe($id);

        return response()->json(['message' => 'Recipe deleted']);
    }
}
