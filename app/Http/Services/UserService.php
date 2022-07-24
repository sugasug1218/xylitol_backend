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
    public function createPreUserService($email)
    {
        $id = $this->preUsers->createPreUserByRequest($email);
        if (!$id) {
            throw new RuntimeException($this->getErrorMessage(ResponseType::PARAM_ERROR), ResponseType::PARAM_ERROR);
        }
        return [
            'id' => $id,
            'token' => $this->preUsers->getToken($id)
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
        $this->exitsCheck($param['preId']);
        $param['email'] = PreUser::find($param['preId'])->email;
        $data = $this->users->registerByRequest($param);
        if (is_null($data)) {
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
        $limit = $this->getTokenLimit();
        $result = $this->preUsers->checkTokenByRequest($limit, $data);
        if (is_null($result)) {
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

    /**
     * メールアドレスが既に登録済みかチェックします
     *
     * @param int $preId
     * @return void
     */
    private function exitsCheck($preId)
    {
        $target = PreUser::PreId($preId)->first();
        $exits_check = User::UserEmail($target['email'])->first();
        if (!is_null($exits_check)) {
            throw new RuntimeException($this->getErrorMessage(ResponseType::EXISTS_ERROR), ResponseType::EXISTS_ERROR);
        }
    }
}
