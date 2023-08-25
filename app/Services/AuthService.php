<?php

namespace App\Services;

use App\Repositories\Auth\AuthRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;


class AuthService
{
    protected $authRepository;

    public function __construct(AuthRepositoryInterface $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    public function handleRegistration(array $data)
    {
        $user = $this->authRepository->register($data);

        $token = JWTAuth::fromUser($user);

        return [
            'user' => $user,
            'token' => $token,
        ];
    }

    public function handleLogin(array $credentials)
    {
        $token = $this->authRepository->login($credentials);
        $user = auth()->user();

        return [
            'user' => $user,
            'token' => $token,
        ];

    }

    public function handleLogout()
    {
        $this->authRepository->logout();
        
        return ['message' => 'Successfully logged out'];
    }

    public function getUserProfile()
    {
        $user = $this->authRepository->getProfile();
        return [
            'user' => $user,
        ];
    }
}