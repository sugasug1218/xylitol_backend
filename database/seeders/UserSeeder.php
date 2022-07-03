<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'テスト_1',
            'email' => 'test_1@example.com',
            'password' => Hash::make("password"),
            'api_token' => null,
            'is_admin' => true
        ]);

        User::create([
            'name' => 'テスト_2',
            'email' => 'test_2@example.com',
            'password' => Hash::make("password"),
            'api_token' => null,
            'is_admin' => false
        ]);
    }
}
