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

    /**
     * @OA\Post(
     *     path="/api/v1/auth/register",
     *     summary="Register a new user",
     *     tags={"Authentication"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/RegisterRequestSchema")
     *     ),
     *     @OA\Response(response="201", description="User registered successfully",
     *         @OA\JsonContent(ref="#/components/schemas/RegistrationResponseSchema")
     *     ),
     *     @OA\Response(response="422", description="Validation error or user registration failed"),
     * )
     */
    public function register(RegisterRequest $request)
    {
        $response = $this->authService->handleRegistration($request->validated());

        return response()->json($response,201);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/auth/login",
     *     summary="User login",
     *     tags={"Authentication"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/LoginRequestSchema")
     *     ),
     *     @OA\Response(response="200", description="User logged in successfully",
     *         @OA\JsonContent(ref="#/components/schemas/LoginResponseSchema")
     *     ),
     *     @OA\Response(response="401", description="Unauthorized"),
     * )
     */
    public function login(LoginRequest $request)
    {
        $response = $this->authService->handleLogin($request->only('email', 'password'));

        return response()->json($response);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/auth/logout",
     *     summary="Logout user",
     *     tags={"Authentication"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(response="200", description="Successfully logged out"),
     *     @OA\Response(response="401", description="Unauthorized"),
     * )
     */
    public function logout()
    {
        return response()->json($this->authService->handleLogout(), 200);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/auth/user-profile",
     *     summary="Get user profile",
     *     tags={"Authentication"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(response="200", description="User profile retrieved successfully",
     *         @OA\JsonContent(ref="#/components/schemas/UserProfileResponseSchema")
     *     ),
     *     @OA\Response(response="401", description="Unauthorized"),
     * )
     */
    public function userProfile()
    {
        return response()->json($this->authService->getUserProfile(), 200);
    }

}
