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
     * @param
     */
    public function createPreUser($email)
    {
        $id = $this->preUsers->createPreUserByRequst($email);
        if (!$id) {
            throw new RuntimeException($this->getErrorMessage(ResponseType::PARAM_ERROR), ResponseType::PARAM_ERROR);
        }
        return $this->preUsers->getRegistToken($id);
    }
}
