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

    /**
     * @OA\Get(
     *     path="/api/v1/recipes",
     *     operationId="getRecipes",
     *     tags={"Recipes"},
     *     summary="Get a list of recipes",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/RecipeResponseSchema"))
     *     ),
     *     security={{"bearerAuth":{}}}
     * )
     */
    public function index()
    {
        $recipes = $this->recipeService->handleGetRecipes();
        return response()->json($recipes);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/recipes",
     *     operationId="createRecipe",
     *     tags={"Recipes"},
     *     summary="Create a new recipe",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/RecipeRequestSchema")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Recipe created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/RecipeResponseSchema")
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized. Token missing or invalid.",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Unauthorized. Token missing or invalid."),
     *             @OA\Property(property="status_code", type="integer", example=401),
     *             @OA\Property(property="error_type", type="string", example="Unauthorized"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Unprocessable Request. Validation errors.",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Unprocessable Request."),
     *             @OA\Property(property="status_code", type="integer", example=422),
     *             @OA\Property(property="error_type", type="string", example="Unprocessable Content"),
     *             @OA\Property(property="errors", type="object"),
     *         ),
     *     ),
     *     security={{"bearerAuth":{}}}
     * )
     */
    public function store(RecipeRequest $request)
    {
        $data = $request->validated();
        $recipe = $this->recipeService->handleCreateRecipe($data);

        return response()->json($recipe, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/recipes/{id}",
     *     operationId="getRecipe",
     *     tags={"Recipes"},
     *     summary="Get details of a specific recipe",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="ID of the recipe"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/RecipeResponseSchema")
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized. Token missing or invalid.",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Unauthorized. Token missing or invalid."),
     *             @OA\Property(property="status_code", type="integer", example=401),
     *             @OA\Property(property="error_type", type="string", example="Unauthorized"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Recipe not found.",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Recipe not found."),
     *             @OA\Property(property="status_code", type="integer", example=404),
     *             @OA\Property(property="error_type", type="string", example="Not Found"),
     *         ),
     *     ),
     *     security={{"bearerAuth":{}}}
     * )
     */
    public function show($id)
    {
        $recipe = $this->recipeService->handleGetRecipe($id);
        return response()->json($recipe);
    }

    /**
     * @OA\Put(
     *     path="/api/v1/recipes/{id}",
     *     operationId="updateRecipe",
     *     tags={"Recipes"},
     *     summary="Update details of a specific recipe",
     *     @OA\Parameter(
     *         name="Authorization",
     *         in="header",
     *         required=true,
     *         @OA\Schema(type="string"),
     *         description="Bearer token"
     *     ),
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="ID of the recipe"
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/RecipeRequestSchema")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Recipe updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/RecipeResponseSchema")
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized. Token missing or invalid.",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Unauthorized. Token missing or invalid."),
     *             @OA\Property(property="status_code", type="integer", example=401),
     *             @OA\Property(property="error_type", type="string", example="Unauthorized"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Ingredient not found.",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Ingredient not found."),
     *             @OA\Property(property="status_code", type="integer", example=404),
     *             @OA\Property(property="error_type", type="string", example="Not Found"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Unprocessable Request. Validation errors.",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Unprocessable Request."),
     *             @OA\Property(property="status_code", type="integer", example=422),
     *             @OA\Property(property="error_type", type="string", example="Unprocessable Content"),
     *             @OA\Property(property="errors", type="object"),
     *         ),
     *     ),
     *     security={{"bearerAuth":{}}}
     * )
     */
    public function update(RecipeRequest $request, $id)
    {
        $data = $request->validated();
        $recipe = $this->recipeService->handleUpdateRecipe($id, $data);

        return response()->json($recipe);
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/recipes/{id}",
     *     operationId="deleteRecipe",
     *     tags={"Recipes"},
     *     summary="Delete a specific recipe",
     *     @OA\Parameter(
     *         name="Authorization",
     *         in="header",
     *         required=true,
     *         @OA\Schema(type="string"),
     *         description="Bearer token"
     *     ),
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="ID of the recipe"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Recipe deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Recipe deleted"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized. Token missing or invalid.",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Unauthorized. Token missing or invalid."),
     *             @OA\Property(property="status_code", type="integer", example=401),
     *             @OA\Property(property="error_type", type="string", example="Unauthorized"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Recipe not found.",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Recipe not found."),
     *             @OA\Property(property="status_code", type="integer", example=404),
     *             @OA\Property(property="error_type", type="string", example="Not Found"),
     *         ),
     *     ),
     *     security={{"bearerAuth":{}}}
     * )
     */
    public function destroy($id)
    {
        $this->recipeService->handleDestroyRecipe($id);

        return response()->json(['message' => 'Recipe deleted']);
    }
}
