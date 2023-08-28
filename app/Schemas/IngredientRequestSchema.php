<?php

namespace App\Schemas;

/**
 * @OA\Schema(
 *     title="Ingredient Request Schema",
 *     description="Schema for creating an ingredient",
 *     required={"name", "quantity"},
 *     @OA\Property(property="name", type="string"),
 *     @OA\Property(property="quantity", type="number", format="float"),
 * )
 */
class IngredientRequestSchema
{
}