<?php

namespace App\Schemas;

/**
 * @OA\Schema(
 *     schema="RegisterRequestSchema",
 *     title="Register Request",
 *     required={"name", "email", "password", "password_confirmation"},
 *     @OA\Property(property="name", type="string"),
 *     @OA\Property(property="email", type="string", format="email"),
 *     @OA\Property(property="password", type="string", format="password", minLength=6),
 *     @OA\Property(property="password_confirmation", type="string", format="password", minLength=6),
 * )
 */
class RegisterRequestSchema {}
