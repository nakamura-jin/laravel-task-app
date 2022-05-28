<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;

    private $token = null;
    protected $model = User::class;

    public function test_login()
    {
        $user = User::factory()->create();
        $response = $this->post('/api/v1/login', [
            'worker_number' => $user->worker_number,
            'password' => 'password'
        ]);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'token', 'token_period', 'name'
        ]);
    }

    public function test_me()
    {
        $user = User::factory()->create();
        $this->post('/api/v1/login', [
            'worker_number' => $user->worker_number,
            'password' => 'password'
        ]);
        $token = JWTAuth::fromUser($user);
        $response = $this->post('/api/v1/me', [
            'Authorization' => 'Bearer' . $token
        ]);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'name', 'worker_number'
        ]);
    }

    public function test_logout()
    {
        $user = User::factory()->create();
        $this->post('/api/v1/login', [
            'worker_number' => $user->worker_number,
            'password' => 'password'
        ]);
        $token = JWTAuth::fromUser($user);
        $response = $this->post('/api/v1/logout', [
            'Authorization' => 'Bearer ' . $token
        ]);
        $response->assertStatus(200);
    }
}
