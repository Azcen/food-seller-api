<?php

namespace Tests\Unit;

use App\Services\AuthService;
use App\Repositories\Auth\AuthRepositoryInterface;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Tests\TestCase;
use App\Helpers\JWTHelper;
use App\Exceptions\CustomException;
use Tests\Fakes\FakeUser;


describe('Auth Service', function () {
    it('should handle registration', function () {
        $mockUser = new FakeUser();
    
        $mockRepository = mock(AuthRepositoryInterface::class);
        $mockRepository->shouldReceive('register')->andReturn($mockUser);
    
        $mockJWTHelper = mock(JWTHelper::class);
        $mockJWTHelper->shouldReceive('fromUser')->with($mockUser)->andReturn('mocked-token');
    
        $authService = new AuthService($mockRepository, $mockJWTHelper);
    
        $data = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'secretpassword',
            'password_confirmation' => 'secretpassword',
        ];
    
        $response = $authService->handleRegistration($data);
    
        expect($response)->toHaveKey('user');
        expect($response)->toHaveKey('token');
    });
    
    it('should handles login', function () {
        $mockUser = new FakeUser();
        $credentials = [
            'email' => $mockUser->email,
            'password' => $mockUser->password,
        ];
        
        $mockRepository = mock(AuthRepositoryInterface::class);
        $mockRepository->shouldReceive('login')->andReturn($mockUser);
        
        $mockJWTHelper = mock(JWTHelper::class);
        $mockJWTHelper->shouldReceive('attempt')->with($credentials)->andReturn('mocked-token');
        
        $authService = new AuthService($mockRepository, $mockJWTHelper);
        
        $response = $authService->handleLogin($credentials);
        
        expect($response)->toHaveKey('user');
        expect($response)->toHaveKey('token');
        expect($response['user']->toArray())->toBe($mockUser->toArray());
    });

    it('should fail handles login', function () {
        $mockUser = new FakeUser();
        $credentials = [
            'email' => $mockUser->email,
            'password' => 'wrongpassword',
        ];
        
        $mockRepository = mock(AuthRepositoryInterface::class);
        $mockRepository->shouldReceive('login')->andReturn($mockUser);
        
        $mockJWTHelper = mock(JWTHelper::class);
        $mockJWTHelper->shouldReceive('attempt')->with($credentials)->andReturn(false);
        
        $authService = new AuthService($mockRepository, $mockJWTHelper);
        
        try {
            $response = $authService->handleLogin($credentials);
        } catch (CustomException $exception) {
            // dd($exception);
            expect($exception->getMessage())->toBe('Wrong user or password');
            expect($exception->getStatusCode())->toBe(401);
        }
    });
    
    it('should handle logout', function () {
        $mockRepository = mock(AuthRepositoryInterface::class);
        $mockRepository->shouldReceive('logout')->once();
        $mockJWTHelper = mock(JWTHelper::class);
        $mockJWTHelper->shouldReceive('invalidate')->once();
    
        $authService = new AuthService($mockRepository, $mockJWTHelper);
    
        $response = $authService->handleLogout();
    
        expect($response)->toBe(['message' => 'Successfully logged out']);
    });
    
    it('should get user profile', function () {
        $mockUser = new FakeUser();
    
        $mockRepository = mock(AuthRepositoryInterface::class);
        // $mockRepository->shouldReceive('getProfile')->andReturn($mockUser);
        $mockJWTHelper = mock(JWTHelper::class);
        $mockJWTHelper->shouldReceive('authenticate')->andReturn($mockUser);
    
        $authService = new AuthService($mockRepository, $mockJWTHelper);
    
        $response = $authService->getUserProfile();
    
        expect($response)->toHaveKey('user');
    });
});



