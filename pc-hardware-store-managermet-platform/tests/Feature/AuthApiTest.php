<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register_and_receive_token(): void
    {
        $response = $this->postJson('/api/v1/auth/register', [
            'name' => 'Mostafa',
            'email' => 'mostafa@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertCreated()
            ->assertJsonStructure([
                'message',
                'token',
                'user' => ['id', 'name', 'email'],
            ]);
    }

    public function test_user_can_login_and_fetch_profile(): void
    {
        $this->postJson('/api/v1/auth/register', [
            'name' => 'Mostafa',
            'email' => 'mostafa@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ])->assertCreated();

        $login = $this->postJson('/api/v1/auth/login', [
            'email' => 'mostafa@example.com',
            'password' => 'password123',
            'device_name' => 'test-suite',
        ]);

        $login->assertOk()->assertJsonStructure(['token', 'user']);
        $token = $login->json('token');

        $this->withHeader('Authorization', 'Bearer '.$token)
            ->getJson('/api/v1/auth/me')
            ->assertOk()
            ->assertJsonPath('user.email', 'mostafa@example.com');

        $this->withHeader('Authorization', 'Bearer '.$token)
            ->postJson('/api/v1/auth/logout')
            ->assertOk();
    }
}
