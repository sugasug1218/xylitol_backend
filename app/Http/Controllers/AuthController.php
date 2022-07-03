<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;
use App\Enums\ResponseType;
use App\Http\Services\ResponseService;
use RuntimeException;

class AuthController extends Controller
{
    // public function __construct(ResponseService $responseService)
    // {
    //     $this->responseService = $responseService;
    // }

    /**
     * ログイン認証
     *
     * @param Request $request
     * @return void
     */
    public function login(
        Request $request,
        ResponseService $responseService
    ) {
        $credentials = $request->only('email', 'password');

        if (auth()->attempt($credentials)) {
            $user = auth()->user();
            $token = $user->createToken('api_token')->accessToken;
            $data = [
                'token' => $token
            ];
            return $responseService->successResponseData($data);
        }

        throw new RuntimeException(
            $responseService->getErrorMessage(ResponseType::AUTH_ERROR),
            ResponseType::AUTH_ERROR
        );
    }
}
