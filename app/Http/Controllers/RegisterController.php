<?php

namespace App\Http\Controllers;

use App\Http\Services\ResponseService;
use App\Http\Services\UserService;
use Illuminate\Http\Request;
use App\Http\Requests\Register\PreRegisterRequest;
use App\Http\Requests\Register\RegisterRequest;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegisterMail;

class RegisterController extends Controller
{
    private $userService;
    private $responseService;

    public function __construct(
        UserService $userService,
        ResponseService $responseService
    ) {
        $this->userService = $userService;
        $this->responseService = $responseService;
        $this->registUrl = "http://localhost:3000/mainRegistation";
    }

    /**
     * リクエストボディを取得します
     *  - 不正パラメータを受け取らないようonlyで取得
     *
     * @param [type] $request
     * @return void
     */
    private function getParam($request)
    {
        $param = $request->only([
            'preId',
            'name',
            'email',
            'password',
            'is_admin'
        ]);
        if (!isset($param['is_admin'])) {
            $param['is_admin'] = 0;
        }
        return $param;
    }

    /**
     * 本登録用URLを生成します
     *
     * @param array $data
     * @return string
     */
    protected function makeRegisterPageUrl($data)
    {
        return $this->registUrl . "?preId=" . $data['id'] . "?token=" . $data['token'];
    }

    /**
     * 仮登録ユーザーを追加します
     *
     * @param Request $request
     * @return void
     */
    public function preRegister(PreRegisterRequest $request)
    {
        $param = $this->getParam($request);
        $email = $param['email'];

        $data = $this->userService->createPreUser($email);
        $url = $this->makeRegisterPageUrl($data);
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

    /**
     * 本登録ユーザーを追加します
     *
     * @param RegisterRequest $request
     * @return void
     */
    public function register(RegisterRequest $request)
    {
        $param = $this->getParam($request);
        $data = $this->userService->register($param);
        $this->updatePreUser($data);
        return $this->responseService->successResponse();
        // return $this->responseService->successResponseData($data);
    }

    /**
     * 仮登録ユーザーの状態を更新します
     * @param int $id
     * @return void
     */
    private function updatePreUser($id)
    {
        $this->userService->updatePreUser($id);
    }
}
