<?php

namespace Tests\Feature;

use App\Models\Medico;
use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MedicoApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Autentica um usuário e retorna o token.
     */
    private function authenticate()
    {
        $usuario = Usuario::factory()->create([
            'email' => 'medico@example.com',
            'password' => bcrypt('password123'), // Criptografa a senha
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'medico@example.com',
            'password' => 'password123',
        ]);

        return $response->json('token');
    }

    /**
     * Testa a criação de um médico.
     */
    public function test_can_create_medico()
    {
        $usuario = Usuario::factory()->create();

        $token = $this->authenticate();

        $data = [
            'regime_trabalhista' => 0, // CLT
            'carga_horaria' => 40,
            'cnpj' => '12345678000123',
            'id_usuario' => $usuario->id,
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->postJson('/api/medicos', $data);

        $response->assertStatus(201);

        $this->assertDatabaseHas('medicos', ['cnpj' => '12345678000123']);
    }

    /**
     * Testa a listagem de médicos.
     */
    public function test_can_list_medicos()
    {
        Medico::factory()->count(3)->create();

        $token = $this->authenticate();

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->getJson('/api/medicos');

        $response->assertStatus(200);

        $this->assertCount(3, $response->json());
    }

    /**
     * Testa a visualização de um médico específico.
     */
    public function test_can_show_medico()
    {
        $medico = Medico::factory()->create();

        $token = $this->authenticate();

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->getJson("/api/medicos/{$medico->id}");

        $response->assertStatus(200);

        $response->assertJson([
            'id' => $medico->id,
            'cnpj' => $medico->cnpj,
        ]);
    }

    /**
     * Testa a atualização de um médico.
     */
    public function test_can_update_medico()
    {
        $medico = Medico::factory()->create();

        $token = $this->authenticate();

        $data = [
            'regime_trabalhista' => 1, // PJ
            'carga_horaria' => 20,
            'cnpj' => '98765432000112',
            'id_usuario' => $medico->id_usuario,
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->putJson("/api/medicos/{$medico->id}", $data);

        $response->assertStatus(200);

        $this->assertDatabaseHas('medicos', ['cnpj' => '98765432000112']);
    }

    /**
     * Testa a exclusão de um médico.
     */
    public function test_can_delete_medico()
    {
        $medico = Medico::factory()->create();

        $token = $this->authenticate();

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->deleteJson("/api/medicos/{$medico->id}");

        $response->assertStatus(200);

        $this->assertDatabaseMissing('medicos', ['id' => $medico->id]);
    }
}

