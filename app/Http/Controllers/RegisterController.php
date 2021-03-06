<?php

namespace App\Http\Controllers;

use App\Http\Services\ResponseService;
use App\Http\Services\UserService;
use Illuminate\Http\Request;
use App\Http\Requests\Register\PreRegisterRequest;
use App\Http\Requests\Register\RegisterRequest;
use App\Http\Requests\Register\AuthTokenRequest;
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
        $this->registUrl = "http://localhost:3000/Registation";
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
            'is_admin',
            'token'
        ]);
        if (!isset($param['is_admin'])) {
            $param['is_admin'] = 0;
        }
        if (isset($param['preId'])) {
            $param['preId'] = intval($param['preId']);
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
        $url = $this->registUrl . "?preId=" . $data['id'] . "&token=" . $data['token'];
        return $url;
    }

    /**
     * 仮登録ユーザーを追加します
     *
     * @param Request $request
     * @return json
     */
    public function preRegister(PreRegisterRequest $request)
    {
        $param = $this->getParam($request);
        $data = $this->userService->createPreUserService($param['email']);
        $this->sendRegisterMail($param['email'], $this->makeRegisterPageUrl($data));
        return $this->responseService->successResponse();
    }

    /**
     * 本登録用メールを送信します
     *
     * @param string $email
     * @param string $url
     */
    private function sendRegisterMail($email, $url)
    {
        Mail::send(new RegisterMail($email, $url));
    }

    /**
     * 本登録ユーザーを追加します
     *
     * @param RegisterRequest $request
     * @return json
     */
    public function register(RegisterRequest $request)
    {
        $param = $this->getParam($request);
        $data = $this->userService->registerService($param);
        $this->updatePreUser($data);
        return $this->responseService->successResponse();
    }

    /**
     * 仮登録ユーザーの状態を更新します
     * @param int $id
     */
    private function updatePreUser($id)
    {
        $this->userService->updatePreUserService($id);
    }

    /**
     * ワンタイムトークンを認証します
     * @param AuthTokenRequest $request
     * @return json
     */
    public function AuthToken(AuthTokenRequest $request)
    {
        $param = $this->getParam($request);
        $this->userService->AuthTokenService($param);
        return $this->responseService->successResponse();
    }


    /**
     * 本登録未完了ユーザーへのフォロー
     *  - 仮登録後、本登録が完了していないユーザーに対しフォローメールを送信
     *  - 同時にワンタイムトークンを再発行して期限をリフレッシュする
     *
     * @return void
     */
    public function IncompleteUserFollow()
    {
        //
        /**
         * 処理の流れ
         * 対象：仮登録済み、状態が完了になっていないユーザー、フォロー回数が3回未満（3回上限）
         * ・抽出した対象のワンタイムトークンをリフレッシュする
         * ・
         * 
         */
    }
}
