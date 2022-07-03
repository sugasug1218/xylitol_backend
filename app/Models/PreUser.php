<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PreUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'access_token',
        'regist_status'
    ];

    /**
     * 仮ユーザーの追加
     * @return void
     */
    public function createPreUserByRequst($option)
    {
        $user = PreUser::create([
            'email' => $option,
            'access_token' => Str::random(80),
            'regist_status' => 0
        ]);
        return $user->id;
    }
    
    /**
     * 本登録用のURLを生成します
     * @param int $id
     * @return void
     */
    public function getRegistToken($id)
    {
        $user = PreUser::find($id)->toArray();
        return $user['access_token'];
    }
}
