<?php

namespace Tests\Feature;

use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UsuarioTest extends TestCase
{
    use RefreshDatabase;

    protected $token;

    // Faz o login com o usuário admin antes de cada teste
    protected function setUp(): void
    {
        parent::setUp();

        // Garante que o usuário admin já exista no banco
        $usuario = Usuario::factory()->create([
            'email' => 'john@example.com',
            'password' => Hash::make('password123'), // Criptografa a senha
        ]);

        // Realiza o login e captura o token JWT
        $response = $this->postJson('/api/login', [
            'email' => 'john@example.com',
            'password' => 'password123',
        ]);

        // Armazena o token JWT retornado
        $this->token = $response->json('token');
    }

    /**
     * Testa a criação de um usuário.
     */
    public function test_can_create_usuario()
    {
        $userData = [
            'nome_completo' => 'John Doe',
            'email' => 'reizin@example.com',
            'password' => 'password123',
            'data_nascimento' => '1990-01-01',
            'sexo' => 'Masculino',
            'rg' => '123456789',
            'cpf' => '12345678901',
            'nome_social' => 'Johnny',
            'telefone' => '123456789',
            'celular' => '987654321',
        ];

        // Usa o token para autenticar a requisição de criação de usuário
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->postJson('/api/usuarios', $userData);

        // Verifica se o status da resposta é 201
        $response->assertStatus(201);

        // Verifica se o usuário foi criado corretamente no banco de dados
        $this->assertDatabaseHas('usuarios', ['email' => 'reizin@example.com']);
    }

    /**
     * Testa a exibição de um usuário.
     */
    public function test_can_show_usuario()
    {
        $usuario = Usuario::factory()->create();

        // Usa o token para autenticar a requisição de exibição de usuário
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->getJson("/api/usuarios/{$usuario->id}");

        $response->assertStatus(200)
            ->assertJson([
                'nome_completo' => $usuario->nome_completo,
                'data_nascimento' => $usuario->data_nascimento,
                'sexo' => $usuario->sexo,
                'rg' => $usuario->rg,
                'cpf' => $usuario->cpf,
            ]);
    }

    /**
     * Testa a atualização de um usuário.
     */
    public function test_can_update_usuario()
    {
        $usuario = Usuario::factory()->create();

        $updatedData = [
            'nome_completo' => 'John Updated',
            'email' => 'johnupdated@example.com',
        ];

        // Usa o token para autenticar a requisição de atualização de usuário
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->putJson("/api/usuarios/{$usuario->id}", $updatedData);

        $response->assertStatus(200);

        $this->assertDatabaseHas('usuarios', ['email' => 'johnupdated@example.com']);
    }

    /**
     * Testa a exclusão de um usuário.
     */
    public function test_can_delete_usuario()
    {
        $usuario = Usuario::factory()->create();

        // Usa o token para autenticar a requisição de exclusão de usuário
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->deleteJson("/api/usuarios/{$usuario->id}");

        $response->assertStatus(200);

        $this->assertDatabaseMissing('usuarios', ['id' => $usuario->id]);
    }
}
