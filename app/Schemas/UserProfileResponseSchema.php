<?php

namespace App\Schemas;

/**
 * @OA\Schema(
 *     schema="UserProfileResponseSchema",
 *     title="User Profile Response",
 *     @OA\Property(property="user", type="object",
 *         @OA\Property(property="id", type="integer", example="1"),
 *         @OA\Property(property="name", type="string", example="Alex Ochoa"),
 *         @OA\Property(property="email", type="string", example="alexx1708@gmail.com"),
 *         @OA\Property(property="email_verified_at", type="string", format="date-time", example=null),
 *         @OA\Property(property="created_at", type="string", format="date-time", example="2023-08-25T04:42:17.000000Z"),
 *         @OA\Property(property="updated_at", type="string", format="date-time", example="2023-08-25T04:42:17.000000Z"),
 *     ),
 *     example={
 *         "user": {
 *             "id": 1,
 *             "name": "Alex Ochoa",
 *             "email": "alexx1708@gmail.com",
 *             "email_verified_at": null,
 *             "created_at": "2023-08-25T04:42:17.000000Z",
 *             "updated_at": "2023-08-25T04:42:17.000000Z"
 *         }
 *     }
 * )
 */
class UserProfileResponseSchema {}
