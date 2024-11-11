<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:refresh');

        $this->seed([UserSeeder::class]);
    }

    public function test_post_register_success()
    {
        $user = User::factory()->make()->toArray();
        $user['password'] = 'password';
        $user['password_confirmation'] = 'password';
        $response = $this->postJson('/api/v1/auth/register', $user);
        $response->assertStatus(201);
    }

    public function test_post_register_fail()
    {
        $user = User::factory()->create(['email' => ''])->toArray();
        $response = $this->postJson('/api/v1/auth/register', $user);
        $response->assertStatus(422);
    }

    public function test_post_login_success()
    {
        $payload = [
            'email' => User::first()->email,
            'password' => '12345678',
        ];
        $response = $this->postJson('/api/v1/auth/login', $payload);
        $response->assertStatus(200);
    }

    public function test_post_login_fail()
    {
        $payload = [
            'email' => User::first()->email,
            'password' => '445353',
        ];
        $response = $this->postJson('/api/v1/auth/login', $payload);
        $response->assertStatus(401);
    }

    public function test_post_login_error_validation()
    {
        $payload = [
            'email' => User::first()->email,
        ];
        $response = $this->postJson('/api/v1/auth/login', $payload);
        $response->assertStatus(422);
    }

    public function test_post_logout_success()
    {
        Sanctum::actingAs(User::first());
        $response = $this->postJson('/api/v1/auth/logout');
        $response->assertStatus(200);
    }
}
