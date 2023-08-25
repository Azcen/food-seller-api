<?php

namespace App\Repositories\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthRepository implements AuthRepositoryInterface
{
    public function register(array $data)
    {
        if ($data['password'] !== $data['password_confirmation']) {
            throw new \InvalidArgumentException('Password confirmation does not match.');
        }
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function login(array $credentials)
    {
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'Could not create token'], 500);
        }

        return $token;
    }

    public function logout()
    {
        $token = JWTAuth::parseToken(); 
        $token->invalidate(); 
    }

    public function getProfile()
    {
        $user = JWTAuth::parseToken()->authenticate();
        return $user;
    }
}