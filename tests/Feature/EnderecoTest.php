<?php

namespace Tests\Feature;

use App\Models\Endereco;
use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EnderecoTest extends TestCase
{
    use RefreshDatabase;

    private $token;

    /**
     * Executa antes de cada teste para autenticar o usuário e obter o token JWT.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $usuario = Usuario::factory()->create([
            'email' => 'user@example.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'user@example.com',
            'password' => 'password123',
        ]);

        $this->token = $response->json('token');
    }

    public function test_can_create_endereco()
    {
        $usuario = Usuario::factory()->create();

        $data = [
            'cep' => '12345678',
            'logradouro' => 'Rua Exemplo',
            'complemento' => 'Apt 101',
            'bairro' => 'Bairro Exemplo',
            'uf' => 'SP',
            'id_usuario' => $usuario->id,
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->postJson('/api/enderecos', $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('enderecos', ['cep' => '12345678']);
    }

    public function test_can_list_enderecos()
    {
        Endereco::factory()->count(3)->create();

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->getJson('/api/enderecos');

        $response->assertStatus(200);
        $this->assertCount(3, $response->json());
    }

    public function test_can_show_endereco()
    {
        $endereco = Endereco::factory()->create();

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->getJson("/api/enderecos/{$endereco->id}");

        $response->assertStatus(200)
            ->assertJson([
                'id' => $endereco->id,
            ]);
    }

    public function test_can_update_endereco()
    {
        $endereco = Endereco::factory()->create();

        // Incluindo os campos obrigatórios
        $data = [
            'cep' => '87654321', // Atualizando o CEP
            'logradouro' => 'Avenida Exemplo', // Campo obrigatório
            'bairro' => 'Bairro Atualizado', // Campo obrigatório
            'uf' => 'SP', // Campo obrigatório
            'id_usuario' => $endereco->id_usuario, // Campo obrigatório, mantendo o mesmo id_usuario
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->putJson("/api/enderecos/{$endereco->id}", $data);

        $response->assertStatus(200);
        $this->assertDatabaseHas('enderecos', ['cep' => '87654321']);
    }

    public function test_can_delete_endereco()
    {
        $endereco = Endereco::factory()->create();

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->deleteJson("/api/enderecos/{$endereco->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('enderecos', ['id' => $endereco->id]);
    }
}
