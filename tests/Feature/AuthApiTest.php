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
     * Teste para verificar se o login retorna o token JWT.
     */
    public function test_can_login_with_valid_credentials()
    {
        // Cria um usuário com senha criptografada
        $usuario = Usuario::factory()->create([
            'email' => 'john@example.com',
            'password' => Hash::make('password123'), // Criptografa a senha
        ]);

        // Faz a requisição de login com as credenciais corretas
        $response = $this->postJson('/api/login', [
            'email' => 'john@example.com',
            'password' => 'password123',
        ]);

        // Verifica se o status de resposta é 200 OK
        $response->assertStatus(200);

        // Verifica se o token JWT foi retornado
        $response->assertJsonStructure([
            'token',
        ]);
    }

    /**
     * Teste para verificar se o login falha com credenciais inválidas.
     */
    public function test_login_fails_with_invalid_credentials()
    {
        // Cria um usuário
        Usuario::factory()->create([
            'email' => 'john@example.com',
            'password' => Hash::make('password123'),
        ]);

        // Faz a requisição de login com uma senha errada
        $response = $this->postJson('/api/login', [
            'email' => 'john@example.com',
            'password' => 'wrongpassword',
        ]);

        // Verifica se o status de resposta é 401 Unauthorized
        $response->assertStatus(401);

        // Verifica se a resposta contém o erro de credenciais inválidas
        $response->assertJson([
            'error' => 'Credenciais inválidas',
        ]);
    }

    /**
     * Teste para verificar se o logout invalida o token JWT.
     */
    public function test_can_logout_after_login()
    {
        // Cria um usuário com senha criptografada
        $usuario = Usuario::factory()->create([
            'email' => 'john@example.com',
            'password' => Hash::make('password123'),
        ]);

        // Faz a requisição de login para obter o token JWT
        $response = $this->postJson('/api/login', [
            'email' => 'john@example.com',
            'password' => 'password123',
        ]);

        // Armazena o token retornado
        $token = $response->json('token');

        // Faz a requisição de logout utilizando o token JWT
        $logoutResponse = $this->postJson('/api/logout', [], [
            'Authorization' => 'Bearer ' . $token,
        ]);

        // Verifica se o logout foi bem-sucedido
        $logoutResponse->assertStatus(200);

        // Verifica se a resposta contém a mensagem de sucesso
        $logoutResponse->assertJson([
            'message' => 'Logout realizado com sucesso',
        ]);
    }

    /**
     * Teste para verificar se uma requisição autenticada falha após o logout.
     */
//    public function test_cannot_access_protected_route_after_logout()
//    {
//        // Cria um usuário
//        $usuario = Usuario::factory()->create([
//            'email' => 'john@example.com',
//            'password' => Hash::make('password123'),
//        ]);
//
//        // Faz a requisição de login para obter o token JWT
//        $response = $this->postJson('/api/login', [
//            'email' => 'john@example.com',
//            'password' => 'password123',
//        ]);
//
//        // Armazena o token retornado
//        $token = $response->json('token');
//
//        // Faz a requisição de logout utilizando o token JWT
//        $this->postJson('/api/logout', [], [
//            'Authorization' => 'Bearer ' . $token,
//        ]);
//
//        // Tenta acessar uma rota protegida com o token inválido (após o logout)
//        $protectedRouteResponse = $this->getJson('/api/me', [
//            'Authorization' => 'Bearer ' . $token,
//        ]);
//
//        // Verifica se o acesso é negado após o logout
//        $protectedRouteResponse->assertStatus(401);
//    }
}
