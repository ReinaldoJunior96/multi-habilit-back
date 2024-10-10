<?php

namespace Tests\Feature;

use App\Models\Agendamento;
use App\Models\Medico;
use App\Models\Usuario;
use App\Models\Atendente;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AgendamentoTest extends TestCase
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

    public function test_can_create_agendamento()
    {
        $medico = Medico::factory()->create();
        $paciente = Usuario::factory()->create();
        $atendente = Atendente::factory()->create();

        $token = $this->authenticate();

        $data = [
            'atendente' => $atendente->id,
            'paciente' => $paciente->id,
            'medico' => $medico->id,
            'data_agendada' => now()->addDays(3),
            'status' => 1,
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->postJson('/api/agendamentos', $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('agendamentos', ['medico' => $medico->id]);
    }

    public function test_can_list_agendamentos()
    {
        Agendamento::factory()->count(3)->create();

        $token = $this->authenticate();

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->getJson('/api/agendamentos');

        $response->assertStatus(200);
        $this->assertCount(3, $response->json());
    }

    public function test_can_show_agendamento()
    {
        $agendamento = Agendamento::factory()->create();

        $token = $this->authenticate();

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->getJson("/api/agendamentos/{$agendamento->id}");

        $response->assertStatus(200)
            ->assertJson([
                'id' => $agendamento->id,
            ]);
    }

    public function test_can_update_agendamento()
    {
        $agendamento = Agendamento::factory()->create();

        $token = $this->authenticate();

        $data = [
            'status' => 2, // Atualizando o status
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->putJson("/api/agendamentos/{$agendamento->id}", $data);

        $response->assertStatus(200);
        $this->assertDatabaseHas('agendamentos', ['status' => 2]);
    }

    public function test_can_delete_agendamento()
    {
        $agendamento = Agendamento::factory()->create();

        $token = $this->authenticate();

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->deleteJson("/api/agendamentos/{$agendamento->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('agendamentos', ['id' => $agendamento->id]);
    }
}
