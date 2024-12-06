<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
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
        $this->renderable(function (NotFoundHttpException $e, $request) {
            \Log::error("Error in Finding Resource: {$e->getMessage()}", [
                'exception' => $e,
            ]);
            if ($request->expectsJson()) {
                return response()->json([
                    'error' => 'Requested Resource Not Found',
                ], 404);
            }
        });

        $this->renderable(function (ModelNotFoundException $e, $request) {
            \Log::error("Error in Finding Model: {$e->getMessage()}", [
                'exception' => $e,
            ]);
            if ($request->expectsJson()) return response()->json([
                'error' => 'Requested Model Not Found',
            ], 404);
        });

        $this->renderable(function (AccessDeniedHttpException $e, $request) {
            \Log::error("Error in Accessing Model: {$e->getMessage()}", [
                'exception' => $e,
            ]);
            if ($request->expectsJson()) return response()->json([
                'error' => 'You don\'t have access to perform this action!',
            ], 401);
        });
    }
}
