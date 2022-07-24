<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use App\Models\User;
// use Illuminate\Support\Facades\Artisan;


class AuthApiTest extends TestCase
{

    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->artisan('migrate');
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_example()
    {
        $user = User::create([
            'name' => 'テスト1',
            'email' => 'test_mail@email.com',
            'password' => 'password'
        ]);

        $count = User::all()->count();

        $this->assertEquals(1, $count);
    }
}
