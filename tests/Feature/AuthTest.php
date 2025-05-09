<?php

namespace Tests\Feature;

use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

use function Pest\Laravel\{get, post};

uses(RefreshDatabase::class);

/**
 * Teste para verificar se o login retorna o token JWT com credenciais válidas.
 */
it('pode fazer login com credenciais válidas', function () {
    // Cria um usuário com senha criptografada
    $usuario = Usuario::factory()->create([
        'email' => 'lucas@admin.com',
        'password' => Hash::make('password123'),
    ]);

    Log::info('Usuário criado para teste de login.', ['email' => $usuario->email]);

    // Faz a requisição de login com as credenciais corretas
    $response = post('/api/login', [
        'email' => 'lucas@admin.com',
        'password' => 'password123',
    ]);

    // Verifica se o status de resposta é 200 OK
    $response->assertStatus(200);

    // Verifica se o token JWT foi retornado
    $response->assertJsonStructure([
        'token',
    ]);

    Log::info('Login realizado com sucesso.', ['email' => 'lucas@admin.com']);
});

/**
 * Teste para verificar se o login falha com credenciais inválidas.
 */
it('falha ao fazer login com credenciais inválidas', function () {
    // Cria um usuário
    $usuario = Usuario::factory()->create([
        'email' => 'john@example.com',
        'password' => Hash::make('password123'),
    ]);

    Log::info('Usuário criado para teste de falha de login.', ['email' => $usuario->email]);

    // Faz a requisição de login com uma senha errada
    $response = post('/api/login', [
        'email' => 'john@example.com',
        'password' => 'wrongpassword',
    ]);

    // Verifica se o status de resposta é 401 Unauthorized
    $response->assertStatus(401);

    // Verifica se a resposta contém o erro de credenciais inválidas
    $response->assertJson([
        'message' => 'Credenciais inválidas.',
    ]);

    Log::warning('Falha no login devido a credenciais inválidas.', ['email' => 'john@example.com']);
});

/**
 * Teste para verificar se o logout invalida o token JWT.
 */
it('pode fazer logout após login', function () {
    // Cria um usuário com senha criptografada
    $usuario = Usuario::factory()->create([
        'email' => 'john@example.com',
        'password' => Hash::make('password123'),
    ]);

    Log::info('Usuário criado para teste de logout.', ['email' => $usuario->email]);

    // Faz a requisição de login para obter o token JWT
    $response = post('/api/login', [
        'email' => 'john@example.com',
        'password' => 'password123',
    ]);

    // Armazena o token retornado
    $token = $response->json('token');

    Log::info('Login realizado com sucesso para teste de logout.', ['email' => 'john@example.com']);

    // Faz a requisição de logout utilizando o token JWT
    $logoutResponse = post('/api/logout', [], [
        'Authorization' => 'Bearer ' . $token,
    ]);

    // Verifica se o logout foi bem-sucedido
    $logoutResponse->assertStatus(200);

    // Verifica se a resposta contém a mensagem de sucesso
    $logoutResponse->assertJson([
        'message' => 'Logout realizado com sucesso.',
    ]);

    Log::info('Logout realizado com sucesso.', ['email' => 'john@example.com']);
});

/**
 * Teste para verificar se uma requisição autenticada falha após o logout.
 */
it('não pode acessar rota protegida após logout', function () {
    // Cria um usuário
    $usuario = Usuario::factory()->create([
        'email' => 'john@example.com',
        'password' => Hash::make('password123'),
    ]);

    Log::info('Usuário criado para teste de acesso após logout.', ['email' => $usuario->email]);

    // Faz a requisição de login para obter o token JWT
    $response = post('/api/login', [
        'email' => 'john@example.com',
        'password' => 'password123',
    ]);

    // Armazena o token retornado
    $token = $response->json('token');

    Log::info('Login realizado com sucesso para teste de acesso após logout.', ['email' => 'john@example.com']);

    // Faz a requisição de logout utilizando o token JWT
    $responseLogout = post('/api/logout', [], [
        'Authorization' => 'Bearer ' . $token,
    ]);
    //dd($responseLogout);

    Log::info('Logout realizado com sucesso para teste de acesso após logout.', ['email' => 'john@example.com']);

    // Tenta acessar uma rota protegida com o token inválido (após o logout)
    $protectedRouteResponse = get('/api/me', [
        'Authorization' => 'Bearer ' . $token,
    ]);
    // dd($protectedRouteResponse->json());
    // Verifica se o acesso é negado após o logout
    $protectedRouteResponse->assertStatus(401);

    Log::warning('Acesso negado a rota protegida após logout.', ['email' => 'john@example.com']);
});

/**
 * Teste para verificar se a rota /api/me retorna o usuário logado.
 */
it('retorna o usuário logado na rota /api/me', function () {
    // Cria um usuário com senha criptografada
    $usuario = Usuario::factory()->create([
        'email' => 'john@example.com',
        'password' => Hash::make('password123'),
    ]);

    Log::info('Usuário criado para teste da rota /api/me.', ['email' => $usuario->email]);

    // Faz a requisição de login para obter o token JWT
    $response = post('/api/login', [
        'email' => 'john@example.com',
        'password' => 'password123',
    ]);

    // Armazena o token retornado
    $token = $response->json('token');

    Log::info('Login realizado com sucesso para teste da rota /api/me.', ['email' => 'john@example.com']);

    // Faz a requisição para a rota /api/me utilizando o token JWT
    $meResponse = get('/api/me', [
        'Authorization' => 'Bearer ' . $token,
    ]);

    // Verifica se o status de resposta é 200 OK
    $meResponse->assertStatus(200);

    // Verifica se a resposta contém os dados do usuário logado
    $meResponse->assertJson([
        'email' => 'john@example.com',
    ]);

    Log::info('Rota /api/me retornou os dados do usuário logado com sucesso.', ['email' => 'john@example.com']);
});

/**
 * Teste para verificar se a rota /api/refresh retorna um novo token JWT.
 */
it('retorna um novo token JWT na rota /api/refresh', function () {
    // Cria um usuário com senha criptografada
    $usuario = Usuario::factory()->create([
        'email' => 'refresh@example.com',
        'password' => Hash::make('password123'),
    ]);

    Log::info('Usuário criado para teste da rota /api/refresh.', ['email' => $usuario->email]);

    // Faz a requisição de login para obter o token JWT
    $response = post('/api/login', [
        'email' => 'refresh@example.com',
        'password' => 'password123',
    ]);

    // Armazena o token retornado
    $token = $response->json('token');

    Log::info('Login realizado com sucesso para teste da rota /api/refresh.', ['email' => 'refresh@example.com']);

    // Faz a requisição para a rota /api/refresh utilizando o token JWT
    $refreshResponse = post('/api/refresh', [], [
        'Authorization' => 'Bearer ' . $token,
    ]);

    // Verifica se o status de resposta é 200 OK
    $refreshResponse->assertStatus(200);

    // Verifica se a resposta contém um novo token JWT
    $refreshResponse->assertJsonStructure([
        'token',
    ]);

    Log::info('Rota /api/refresh retornou um novo token JWT com sucesso.', ['email' => 'refresh@example.com']);
});
