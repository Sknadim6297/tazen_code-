<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

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
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Render an exception into an HTTP response.
     */
    public function render($request, Throwable $exception): Response
    {
        // Handle HTTP exceptions (404, 403, 500, etc.)
        if ($exception instanceof HttpException) {
            $statusCode = $exception->getStatusCode();
            
            // Check if we have a custom error view for this status code
            if (view()->exists("errors.{$statusCode}")) {
                return response()->view("errors.{$statusCode}", [
                    'exception' => $exception,
                    'statusCode' => $statusCode
                ], $statusCode);
            }
            
            // Fallback to 404 for any other HTTP errors if 404 view exists
            if ($statusCode !== 404 && view()->exists('errors.404')) {
                return response()->view('errors.404', [
                    'exception' => $exception,
                    'statusCode' => $statusCode
                ], $statusCode);
            }
        }

        return parent::render($request, $exception);
    }
}
