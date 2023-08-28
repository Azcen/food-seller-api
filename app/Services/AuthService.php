<?php

namespace App\Services;

use App\Repositories\Auth\AuthRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Helpers\JWTHelper;
use App\Exceptions\CustomException;

class AuthService
{
    protected $authRepository;
    protected $jwtHelper;

    public function __construct(AuthRepositoryInterface $authRepository, JWTHelper $jwtHelper)
    {
        $this->authRepository = $authRepository;
        $this->jwtHelper = $jwtHelper;
    }

    public function handleRegistration(array $data)
    {
        $user = $this->authRepository->register($data);

        $token = $this->jwtHelper->fromUser($user);

        return [
            'user' => $user,
            'token' => $token,
        ];
    }

    public function handleLogin(array $credentials)
    {
        $token = $this->jwtHelper->attempt($credentials);
        if (!$token) {
            throw new CustomException('Wrong user or password', 401);
        }
        
        $user = $this->authRepository->login();

        return [
            'user' => $user,
            'token' => $token,
        ];
    }

    public function handleLogout()
    {
        $this->jwtHelper->invalidate();
        $this->authRepository->logout();
        
        return ['message' => 'Successfully logged out'];
    }

    public function getUserProfile()
    {
        $user = $this->jwtHelper->authenticate();
        return [
            'user' => $user,
        ];
    }
}