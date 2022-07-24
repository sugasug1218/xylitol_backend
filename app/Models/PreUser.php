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
     * エンティティ生成
     * @param int $id
     * @return void
     */
    public function scopePreId($query, $id)
    {
        return $query->where("id", "=", $id);
    }

    /**
     * 仮ユーザーの追加
     * @return void
     */
    public function createPreUserByRequest($option)
    {
        $user = PreUser::create([
            'email' => $option,
            'access_token' => Str::random(80),
            'regist_status' => 0
        ]);
        return $user->id;
    }

    /**
     * 本登録URL生成のためのワンタイムトークンを取得します
     * @param int $id
     * @return void
     */
    public function getToken($id)
    {
        $user = PreUser::find($id)->toArray();
        return $user['access_token'];
    }

    /**
     * 本登録完了ステータスに更新します
     * @param int $id
     * @return void
     */
    public function updateRegistStatus($id)
    {
        return PreUser::where("id", "=", $id)->update([
            'regist_status' => 1
        ]);
    }

    /**
     * ワンタイムトークンの有効性をチェックします
     *  - idが存在している
     *  - tokenが存在している
     *  - created_atが24時間以内
     * @param string $limit
     * @param array $data
     * @return void
     */
    public function checkTokenByRequest($limit, $data)
    {
        return PreUser::where("id", "=", $data['preId'])
            ->where("access_token", "=", $data['token'])
            ->where("created_at", "<", $limit)
            ->where("regist_status", "=", 0)
            ->first();
    }
}
