<?php
namespace Tests\Feature;

use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;

class UsuarioApiTest extends TestCase
{
    use RefreshDatabase;

    private function authenticate()
    {
        // Cria um usuário para autenticação
        $usuario = Usuario::factory()->create([
            'email' => 'user@example.com',
            'password' => Hash::make('password123'), // Criptografa a senha
        ]);

        // Faz login para obter o token JWT
        $response = $this->postJson('/api/login', [
            'email' => 'user@example.com',
            'password' => 'password123',
        ]);

        $token = $response->json('token');

        // Retorna o token para ser utilizado nas requisições
        return $token;
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

        // Faz a requisição para o endpoint de criação (público, sem autenticação)
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

        // Autentica e obtém o token
        $token = $this->authenticate();

        // Faz a requisição para o endpoint de visualização com o token
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->getJson("/api/usuarios/{$usuario->id}");

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

        // Autentica e obtém o token
        $token = $this->authenticate();

        // Faz a requisição para o endpoint de atualização com o token
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->putJson("/api/usuarios/{$usuario->id}", $updatedData);

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

        // Autentica e obtém o token
        $token = $this->authenticate();

        // Faz a requisição para o endpoint de exclusão com o token
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->deleteJson("/api/usuarios/{$usuario->id}");

        // Verifica se o status de resposta é 200 OK
        $response->assertStatus(200);

        // Verifica se o usuário foi excluído do banco de dados
        $this->assertDatabaseMissing('usuarios', ['id' => $usuario->id]);
    }
}
