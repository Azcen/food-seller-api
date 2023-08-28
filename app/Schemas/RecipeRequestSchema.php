<?php

namespace App\Schemas;

/**
 * @OA\Schema(
 *     schema="RecipeRequestSchema",
 *     title="Recipe Request",
 *     required={"name", "type", "ingredients", "price", "description"},
 *     @OA\Property(property="name", type="string"),
 *     @OA\Property(property="type", type="string"),
 *     @OA\Property(property="ingredients", type="array",
 *         @OA\Items(type="object",
 *             @OA\Property(property="id", type="integer"),
 *             @OA\Property(property="quantity", type="number")
 *         )
 *     ),
 *     @OA\Property(property="price", type="number"),
 *     @OA\Property(property="description", type="string"),
 * )
 */
class RecipeRequestSchema {}