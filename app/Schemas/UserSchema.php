<?php

namespace App\Schemas;

/**
 * @OA\Schema(
 *     schema="UserSchema",
 *     title="User",
 *     @OA\Property(property="name", type="string"),
 *     @OA\Property(property="email", type="string"),
 *     @OA\Property(property="created_at", type="string"),
 *     @OA\Property(property="updated_at", type="string"),
 *     @OA\Property(property="id", type="integer"),
 * )
 */
class UserSchema {}

