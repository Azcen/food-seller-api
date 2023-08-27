<?php

namespace App\Schemas;

/**
 * @OA\Schema(
 *     schema="LoginResponseSchema",
 *     title="Login Response",
 *     @OA\Property(property="user", type="object",
 *         @OA\Property(property="id", type="integer", example="1"),
 *         @OA\Property(property="name", type="string", example="Alex Ochoa"),
 *         @OA\Property(property="email", type="string", example="alexx1708@gmail.com"),
 *         @OA\Property(property="email_verified_at", type="string", format="date-time", example=null),
 *         @OA\Property(property="created_at", type="string", format="date-time", example="2023-08-25T04:42:17.000000Z"),
 *         @OA\Property(property="updated_at", type="string", format="date-time", example="2023-08-25T04:42:17.000000Z"),
 *     ),
 *     @OA\Property(property="token", type="string", example="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vZm9vZC1zZWxsZXItYXBpLnRlc3QvYXBpL3YxL2F1dGgvbG9naW4iLCJpYXQiOjE2OTMxMTQ1MTIsImV4cCI6MTY5MzExODExMiwibmJmIjoxNjkzMTE0NTEyLCJqdGkiOiJIcVhpYnNIaWJUTFl3djRaIiwic3ViIjoiMSIsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ.971zQ_OiJxaOTVg7xsnFSJheKtQugZkWjZ4GFw8rVzo"),
 * )
 */
class LoginResponseSchema {}
