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

    /**
     * @OA\Get(
     *     path="/api/v1/ingredients",
     *     operationId="getIngredients",
     *     tags={"Ingredients"},
     *     summary="Get a list of ingredients",
     *     @OA\Parameter(
     *         name="Authorization",
     *         in="header",
     *         required=true,
     *         @OA\Schema(type="string"),
     *         description="Bearer token"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/IngredientResponseSchema")
     *         )
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
     *     security={{"bearerAuth":{}}}
     * )
     */
    public function index()
    {
        $ingredients = $this->ingredientService->handleGetIngredients();
        return response()->json($ingredients);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/ingredients",
     *     operationId="createIngredient",
     *     tags={"Ingredients"},
     *     summary="Create a new ingredient",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/IngredientRequestSchema")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Ingredient created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/IngredientResponseSchema")
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
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized. Token missing or invalid.",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Unauthorized. Token missing or invalid."),
     *             @OA\Property(property="status_code", type="integer", example=401),
     *             @OA\Property(property="error_type", type="string", example="Unauthorized"),
     *         ),
     *     ),
     *     security={{"bearerAuth":{}}}
     * )
     */
    public function store(IngredientRequest $request)
    {
        $data = $request->validated();
        $ingredient = $this->ingredientService->handleCreateIngredient($data);

        return response()->json($ingredient, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/ingredients/{id}",
     *     operationId="getIngredient",
     *     tags={"Ingredients"},
     *     summary="Get details of a specific ingredient",
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
     *         description="ID of the ingredient"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/IngredientResponseSchema")
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
     *     security={{"bearerAuth":{}}}
     * )
     */
    public function show($id)
    {
        $ingredient = $this->ingredientService->handleGetIngredient($id);
        return response()->json($ingredient);
    }

    /**
     * @OA\Put(
     *     path="/api/v1/ingredients/{id}",
     *     operationId="updateIngredient",
     *     tags={"Ingredients"},
     *     summary="Update details of a specific ingredient",
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
     *         description="ID of the ingredient"
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/IngredientRequestSchema")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Ingredient updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/IngredientResponseSchema")
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
    public function update(IngredientRequest $request, $id)
    {
        $data = $request->validated();
        $ingredient = $this->ingredientService->handleUpdateIngredient($id, $data);

        return response()->json($ingredient);
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/ingredients/{id}",
     *     operationId="deleteIngredient",
     *     tags={"Ingredients"},
     *     summary="Delete a specific ingredient",
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
     *         description="ID of the ingredient"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Ingredient deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Ingredient deleted"),
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
     *         description="Ingredient not found.",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Ingredient not found."),
     *             @OA\Property(property="status_code", type="integer", example=404),
     *             @OA\Property(property="error_type", type="string", example="Not Found"),
     *         ),
     *     ),
     *     security={{"bearerAuth":{}}}
     * )
     */
    public function destroy($id)
    {
        $this->ingredientService->handleDestroyIngredient($id);

        return response()->json(['message' => 'Ingredient deleted']);
    }
}
