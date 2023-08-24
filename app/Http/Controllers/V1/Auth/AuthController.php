<?php

namespace App\Http\Controllers\V1\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\LogoutRequest;
use App\Services\AuthService;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(RegisterRequest $request)
    {
        $response = $this->authService->handleRegistration($request->validated());

        return response()->json($response,201);
    }

    public function login(LoginRequest $request)
    {
        $response = $this->authService->handleLogin($request->only('email', 'password'));

        return response()->json($response);
    }

    public function logout()
    {
        return response()->json($this->authService->handleLogout(), 200);
    }

    public function userProfile()
    {
        return response()->json($this->authService->getUserProfile(), 200);
    }

    public function test()
    {
        return response()->json([
            'msg' => 'test',
        ]);
    }

}
