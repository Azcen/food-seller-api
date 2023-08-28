<?php

namespace App\Schemas;

/**
 * @OA\Schema(
 *     schema="OrderResponseSchema",
 *     title="Order Response",
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="client_name", type="string"),
 *     @OA\Property(property="status", type="string"),
 *     @OA\Property(property="details", type="array",
 *         @OA\Items(type="object",
 *             @OA\Property(property="id", type="integer"),
 *             @OA\Property(property="quantity", type="integer"),
 *             @OA\Property(property="recipe", ref="#/components/schemas/RecipeResponseSchema"),
 *             @OA\Property(property="comments", type="string"),
 *         )
 *     ),
 * )
 */
class OrderResponseSchema {}
