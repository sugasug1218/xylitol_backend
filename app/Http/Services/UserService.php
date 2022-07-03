<?php

namespace App\Http\Services;

use App\Models\User;
use App\Models\PreUser;
use App\Http\Services\ResponseService;
use App\Enums\ResponseType;
use RuntimeException;

class UserService extends ResponseService
{
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
    public function createPreUser($email)
    {
        $id = $this->preUsers->createPreUserByRequest($email);
        if (!$id) {
            throw new RuntimeException($this->getErrorMessage(ResponseType::PARAM_ERROR), ResponseType::PARAM_ERROR);
        }
        $token = $this->preUsers->getRegistToken($id);
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
    public function register($param)
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
    public function updatePreUser($id)
    {
        $res = $this->preUsers->updateRegistStatus($id);
        if (!$res) {
            throw new RuntimeException($this->getErrorMessage(ResponseType::DB_ERROR), ResponseType::DB_ERROR);
        }
        return true;
    }
}
