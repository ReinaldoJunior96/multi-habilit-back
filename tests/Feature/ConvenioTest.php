<?php

namespace Tests\Feature;

use App\Models\Convenio;
use App\Models\Paciente;
use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ConvenioTest extends TestCase
{
    use RefreshDatabase;

    private function authenticate()
    {
        $usuario = Usuario::factory()->create([
            'email' => 'user@example.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'user@example.com',
            'password' => 'password123',
        ]);

        return $response->json('token');
    }

    public function test_can_create_convenio()
    {
        $paciente = Paciente::factory()->create();

        $token = $this->authenticate();

        $data = [
            'empresa' => 'Convenio Saúde2',
            'tipo' => 'Plano Completo',
            'vencimento' => '2024-10-10',
            'percentual_coparticipacao' => 20,
            'particular' => 0,
            'id_paciente' => $paciente->id
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->postJson('/api/convenios', $data);

        // Exibe a resposta completa para ajudar no debug


        // Verifica se a resposta foi bem sucedida (201)
        $response->assertStatus(201);

        // Verifica se o convênio foi criado no banco de dados
        $this->assertDatabaseHas('convenios', ['empresa' => 'Convenio Saúde2']);
    }

    public function test_can_list_convenios()
    {
        Convenio::factory()->count(3)->create();

        $token = $this->authenticate();

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->getJson('/api/convenios');

        $response->assertStatus(200);
        $this->assertCount(3, $response->json());
    }

    public function test_can_show_convenio()
    {
        $convenio = Convenio::factory()->create();

        $token = $this->authenticate();

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->getJson("/api/convenios/{$convenio->id}");

        $response->assertStatus(200)
            ->assertJson([
                'id' => $convenio->id,
                'empresa' => $convenio->empresa,
            ]);
    }

    public function test_can_update_convenio()
    {
        $convenio = Convenio::factory()->create();

        $token = $this->authenticate();

        $data = [
            'empresa' => 'Convenio Atualizado',
            'tipo' => $convenio->tipo,
            'vencimento' => $convenio->vencimento,
            'percentual_coparticipacao' => $convenio->percentual_coparticipacao,
            'particular' => $convenio->particular,
            'id_paciente' => $convenio->id_paciente,
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->putJson("/api/convenios/{$convenio->id}", $data);

        $response->assertStatus(200);
        $this->assertDatabaseHas('convenios', ['empresa' => 'Convenio Atualizado']);
    }

    public function test_can_delete_convenio()
    {
        $convenio = Convenio::factory()->create();

        $token = $this->authenticate();

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->deleteJson("/api/convenios/{$convenio->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('convenios', ['id' => $convenio->id]);
    }
}
