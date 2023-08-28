<?php

namespace App\Schemas;

/**
 * @OA\Schema(
 *     title="Ingredient Response Schema",
 *     description="Schema for an ingredient response",
 *     @OA\Property(property="name", type="string"),
 *     @OA\Property(property="quantity", type="integer"),
 *     @OA\Property(property="updated_at", type="string", format="date-time"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="id", type="integer"),
 *     example={
 *         "name": "Tomato",
 *         "quantity": 20,
 *         "updated_at": "2023-08-28T00:54:54.000000Z",
 *         "created_at": "2023-08-28T00:54:54.000000Z",
 *         "id": 1
 *     }
 * )
 */
class IngredientResponseSchema
{
}