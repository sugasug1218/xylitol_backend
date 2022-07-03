<?php

namespace App\Http\Controllers;

use App\Http\Services\ResponseService;
use App\Http\Services\UserService;
use Illuminate\Http\Request;
use App\Http\Requests\Register\PreRegisterRequest;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegisterMail;

class RegisterController extends Controller
{
    public function __construct(
        UserService $userService,
        ResponseService $responseService
    ) {
        $this->userService = $userService;
        $this->responseService = $responseService;
        $this->registUrl = "http://localhost:3000/";
    }


    /**
     * 本登録用URLを生成します
     *
     * @param string $token
     * @return string
     */
    protected function makeRegisterPageUrl($token)
    {
        $url =  $this->registUrl . "?token=" . $token;
        return $url;
    }

    /**
     * 仮登録ユーザーを追加します
     *
     * @param Request $request
     * @return void
     */
    public function preRegister(PreRegisterRequest $request)
    {
        $email = $request['email'];
        $token = $this->userService->createPreUser($email);
        $url = $this->makeRegisterPageUrl($token);
        return $this->sendRegisterMail($email, $url);
    }

    /**
     * 本登録用メールを送信します
     *
     * @param string $email
     * @param string $url
     * @return json
     */
    private function sendRegisterMail($email, $url)
    {
        Mail::send(new RegisterMail($email, $url));
        return $this->responseService->successResponse();
    }
}
