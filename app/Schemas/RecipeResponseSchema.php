<?php

namespace App\Schemas;

/**
 * @OA\Schema(
 *     schema="RecipeResponseSchema",
 *     title="Recipe Response",
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="name", type="string"),
 *     @OA\Property(property="type", type="string"),
 *     @OA\Property(property="price", type="string", example="120.00"),
 *     @OA\Property(property="description", type="string"),
 *     @OA\Property(property="ingredients", type="array",
 *         @OA\Items(type="object",
 *             @OA\Property(property="id", type="integer"),
 *             @OA\Property(property="name", type="string"),
 *             @OA\Property(property="quantity", type="string", example="1.00"),
 *         )
 *     ),
 * )
 */
class RecipeResponseSchema {}
