<?php

namespace Tests\Feature;

use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UsuarioApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Testa o endpoint de listagem de usuários (GET /usuarios).
     */
    public function test_can_list_usuarios()
    {
        // Cria alguns usuários
        Usuario::factory()->count(3)->create();

        // Faz a requisição para o endpoint de listagem
        $response = $this->getJson('/api/usuarios');

        // Verifica se o status de resposta é 200 OK
        $response->assertStatus(200);

        // Verifica se a resposta contém os usuários criados
        $response->assertJsonCount(3, 'data');
    }

    /**
     * Testa o endpoint de criação de usuário (POST /usuarios).
     */
    public function test_can_create_usuario()
    {
        // Define os dados de um novo usuário
        $userData = [
            'nome_completo' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password123',
            'data_nascimento' => '1990-01-01',
            'sexo' => 'Masculino',
            'rg' => '123456789',
            'cpf' => '12345678901',
            'nome_social' => 'Johnny',
            'telefone' => '123456789',
            'celular' => '987654321'
        ];

        // Faz a requisição para o endpoint de criação
        $response = $this->postJson('/api/usuarios', $userData);

        // Verifica se o status de resposta é 201 Created
        $response->assertStatus(201);

        // Verifica se o usuário foi criado corretamente
        $this->assertDatabaseHas('usuarios', ['email' => 'john@example.com']);
    }

    /**
     * Testa o endpoint de exibição de um único usuário (GET /usuarios/{id}).
     */
    public function test_can_show_usuario()
    {
        // Cria um usuário
        $usuario = Usuario::factory()->create();

        // Faz a requisição para o endpoint de visualização
        $response = $this->getJson("/api/usuarios/{$usuario->id}");

        // Verifica se o status de resposta é 200 OK
        $response->assertStatus(200);

        // Verifica se a resposta contém os dados do usuário criado dentro de "data"
        $response->assertJson([
            'data' => [
                'nome_completo' => $usuario->nome_completo,
                'data_nascimento' => $usuario->data_nascimento,
                'sexo' => $usuario->sexo,
                'rg' => $usuario->rg,
                'cpf' => $usuario->cpf,
                'nome_social' => $usuario->nome_social,
                'telefone' => $usuario->telefone,
                'celular' => $usuario->celular,
            ]
        ]);
    }

    /**
     * Testa o endpoint de atualização de usuário (PUT /usuarios/{id}).
     */
    public function test_can_update_usuario()
    {
        // Cria um usuário
        $usuario = Usuario::factory()->create();

        // Define os dados atualizados
        $updatedData = [
            'nome_completo' => 'John Updated',
            'email' => 'johnupdated@example.com'
        ];

        // Faz a requisição para o endpoint de atualização
        $response = $this->putJson("/api/usuarios/{$usuario->id}", $updatedData);

        // Verifica se o status de resposta é 200 OK
        $response->assertStatus(200);

        // Verifica se o usuário foi atualizado corretamente
        $this->assertDatabaseHas('usuarios', ['email' => 'johnupdated@example.com']);
    }

    /**
     * Testa o endpoint de exclusão de usuário (DELETE /usuarios/{id}).
     */
    public function test_can_delete_usuario()
    {
        // Cria um usuário
        $usuario = Usuario::factory()->create();

        // Faz a requisição para o endpoint de exclusão
        $response = $this->deleteJson("/api/usuarios/{$usuario->id}");

        // Verifica se o status de resposta é 200 OK
        $response->assertStatus(200);

        // Verifica se o usuário foi excluído do banco de dados
        $this->assertDatabaseMissing('usuarios', ['id' => $usuario->id]);
    }
}
