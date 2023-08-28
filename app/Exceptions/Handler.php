<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            // You can perform any custom reporting here
        });

        $this->renderable(function (Throwable $e, $request) {
            $customExceptionHandler = app(\App\Exceptions\CustomExceptionHandler::class);
            return $customExceptionHandler->render($request, $e);
        });
    }
}
