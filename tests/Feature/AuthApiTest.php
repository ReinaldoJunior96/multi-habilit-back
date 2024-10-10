<?php

namespace Tests\Feature;

use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Testa se o login retorna o token JWT.
     */
    public function test_can_login_with_valid_credentials()
    {
        $usuario = Usuario::factory()->create([
            'email' => 'john@example.com',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'john@example.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'token',
            ]);
    }

    /**
     * Testa se o login falha com credenciais inválidas.
     */
    public function test_login_fails_with_invalid_credentials()
    {
        Usuario::factory()->create([
            'email' => 'john@example.com',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'john@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(401)
            ->assertJson([
                'error' => 'Credenciais inválidas',
            ]);
    }

    /**
     * Testa o logout com um token válido.
     */
    public function test_can_logout_after_login()
    {
        $usuario = Usuario::factory()->create([
            'email' => 'john@example.com',
            'password' => Hash::make('password123'),
        ]);

        $loginResponse = $this->postJson('/api/login', [
            'email' => 'john@example.com',
            'password' => 'password123',
        ]);

        $token = $loginResponse->json('token');

        $logoutResponse = $this->postJson('/api/logout', [], [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $logoutResponse->assertStatus(200)
            ->assertJson([
                'message' => 'Logout realizado com sucesso',
            ]);
    }
}
