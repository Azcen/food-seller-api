<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Http\JsonResponse;

class CustomExceptionHandler extends ExceptionHandler
{
    public function render($request, Throwable $exception)
    {
        $statusCode = $this->getStatusCodeFromException($exception);
        $responseData = [
            'message' => $exception->getMessage(),
            'status_code' => $statusCode,
            'error_type' => $this->getStatusType($statusCode),
        ];
        $this->logException($exception, $responseData);
        return new JsonResponse($responseData, $statusCode);

    }

    private function getStatusCodeFromException(Throwable $exception)
    {
        return method_exists($exception, 'getStatusCode')
            ? $exception->getStatusCode()
            : 500;
    }

    private function logException(Throwable $exception, array $responseData)
    {
        // Log the exception 
        \Log::error('Exception occurred: ' . $exception->getMessage(), [
            'exception' => get_class($exception),
            'response_data' => $responseData,
            'trace' => $exception->getTraceAsString(),
        ]);
    }

    private function getStatusType($code) {
        $types = [
            '400' => 'Bad Request',
            '401' => 'Unauthorized',
            '403' => 'Forbidden',
            '404' => 'Not Found',
            '405' => 'HTTP Method Not Allowed',
            '500' => 'Internal Server Error (DOOMED)',
        ];

        return $types[$code] ?? 'Unexpected Error';
    }
}
