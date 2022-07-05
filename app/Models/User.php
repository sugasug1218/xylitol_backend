<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use App\Models\PreUser;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'preUser_id',
        'name',
        'email',
        'password',
        'is_admin'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'create_date' => 'datetime',
        'updated_date' => 'datetime'
    ];

    /**
     * 顧客1件のエンティティを作ります
     *
     * @param int $id
     * @return collection
     */
    private function getUserById($id)
    {
        //
    }

    /**
     * ユーザーの追加
     *
     * @return void
     */
    public function registerByRequest($option)
    {
        $preUser = PreUser::where("id", "=", $option['preId'])->first();
        $email = $preUser['email'];
        return User::create([
            'preUser_id' => $option['preId'],
            'name' => $option['name'],
            'email' => $email,
            'password' => Hash::make($option['password']),
            'is_admin' => $option['is_admin']
        ])->toArray();
    }
}
