<?php

namespace App\Helpers;

use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Models\User;

class JWTHelper
{
    public function attempt(array $credentials)
    {
        try {
            return JWTAuth::attempt($credentials);
        } catch (JWTException $e) {
            throw new Exception('Could not create token', 500);
        }
    }

    public function fromUser($user)
    {
        return JWTAuth::fromUser($user);
    }

    public function invalidate()
    {
        JWTAuth::parseToken()->invalidate();
    }

    public function authenticate()
    {
        return JWTAuth::parseToken()->authenticate();
    }




}
