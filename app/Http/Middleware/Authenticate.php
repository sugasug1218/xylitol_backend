<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use App\Http\Services\ResponseService;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        $responseService = new ResponseService();
        if (! $request->expectsJson()) {
            return $responseService->AuthenticationExceptionResponse();
            // return route('login');
        }
    }
}
