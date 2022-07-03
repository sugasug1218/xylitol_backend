<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Authorization extends Model
{
    use HasFactory;

    /**
     * Usersとのリレーション定義
     *
     * @return void
     */
    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
