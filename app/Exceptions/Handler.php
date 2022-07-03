<?php

namespace App\Exceptions;

use App\Http\Services\ResponseService;
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use PDOException;
use RuntimeException;
use Throwable;
use Illuminate\Auth\AuthenticationException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
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
     *
     *
     */
    public function render($request, Throwable $e)
    {
        $responseService = new ResponseService();

        if ($e instanceof PDOException) {
            // return $responseService->pdoExceptionResponse();
        } elseif ($e instanceof RuntimeException) {
            return $responseService->runtimeExceptionResponse($e);
        } elseif ($e instanceof AuthenticationException) {
            return $responseService->AuthenticationExceptionResponse();
        }
        // elseif ($e instanceof Exception) {
        //     return $responseService->unknownExceptionResponse();
        // }

        return parent::render($request, $e);
    }
}
