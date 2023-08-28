<?php

namespace App\Schemas;

/**
 * @OA\Schema(
 *     schema="OrderRequestSchema",
 *     title="Order Request",
 *     required={"client_name", "status", "details"},
 *     @OA\Property(property="client_name", type="string"),
 *     @OA\Property(property="status", type="string"),
 *     @OA\Property(property="details", type="array",
 *         @OA\Items(type="object",
 *             @OA\Property(property="recipe_id", type="integer"),
 *             @OA\Property(property="quantity", type="integer"),
 *             @OA\Property(property="comments", type="string"),
 *         )
 *     ),
 * )
 */
class OrderRequestSchema {}
