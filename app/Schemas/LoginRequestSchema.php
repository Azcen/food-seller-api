<?php

namespace App\Schemas;

/**
 * @OA\Schema(
 *     schema="LoginRequestSchema",
 *     title="Login Request",
 *     required={"email", "password"},
 *     @OA\Property(property="email", type="string", format="email"),
 *     @OA\Property(property="password", type="string", format="password"),
 * )
 */
class LoginRequestSchema {}