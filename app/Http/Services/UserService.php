<?php

namespace App\Http\Services;

use App\Models\User;
use App\Models\PreUser;
use App\Http\Services\ResponseService;
use App\Enums\ResponseType;
use DateTime;
use RuntimeException;
use Carbon\Carbon;

class UserService extends ResponseService
{
    private $accessDateTime;

    public function __construct(
        User $user,
        PreUser $preUser
    ) {
        $this->users = $user;
        $this->preUsers = $preUser;
    }

    /**
     * 仮ユーザー登録をします
     * @param string $email
     * @return string
     */
    public function createPreUserService($email)
    {
        $id = $this->preUsers->createPreUserByRequest($email);
        if (!$id) {
            throw new RuntimeException($this->getErrorMessage(ResponseType::PARAM_ERROR), ResponseType::PARAM_ERROR);
        }
        $token = $this->preUsers->getToken($id);
        return [
            'id' => $id,
            'token' => $token
        ];
    }

    /**
     * 本登録ユーザーを追加します
     *
     * @param array $param
     * @return void
     */
    public function registerService($param)
    {
        $data = $this->users->registerByRequest($param);
        if (!$data) {
            throw new RuntimeException($this->getErrorMessage(ResponseType::DB_ERROR), ResponseType::DB_ERROR);
        }
        return $data;
    }

    /**
     * 仮登録ユーザーの登録ステータスを更新します
     *
     * @param int $id
     * @return void
     */
    public function updatePreUserService($id)
    {
        $this->preUsers->updateRegistStatus($id);
    }

    /**
     * ワンタイムトークンを認証します
     * @param array $data
     * @return void
     */
    public function AuthTokenService($data)
    {
        // 現在日時を取得する
        $Limit = $this->getTokenLimit();
        $result = $this->preUsers->checkTokenByRequest($Limit, $data);
        if (empty($result)) {
            throw new RuntimeException($this->getErrorMessage(ResponseType::AUTH_ERROR), ResponseType::AUTH_ERROR);
        }
        return $result;
    }

    /**
     * 現在時刻を取得します
     *
     * @return string
     */
    private function getTokenLimit()
    {
        return date("Y-m-d H:i:s", strtotime("+24 hour"));
    }
}
