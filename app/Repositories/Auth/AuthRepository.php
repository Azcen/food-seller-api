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

    public function login()
    {
        return auth()->user();
    }

    public function logout()
    {
        $token = JWTAuth::parseToken(); 
        $token->invalidate(); 
        Auth::logout();
    }

    public function getProfile()
    {
        $user = JWTAuth::parseToken()->authenticate();
        return $user;
    }
}