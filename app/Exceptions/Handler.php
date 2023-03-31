<?php

namespace App\Exceptions;

use Throwable;
use Exception;

use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
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
        $this->renderable(function (NotFoundHttpException $e) {
            return failureJSONResponse($e->getMessage(), 404);
        });

        $this->renderable(function (ValidationException $e) {
            return failureJSONResponse($e->getMessage(), 400);
        });

        $this->renderable(function (QueryException $e) {
            return failureJSONResponse($e->getMessage(), 500);
        });

        $this->reportable(function (Throwable $e) {
            return failureJSONResponse($e->getMessage(), 500);
        });

        $this->reportable(function (Exception $e) {
            return failureJSONResponse($e->getMessage(), 500);
        });
    }
}
