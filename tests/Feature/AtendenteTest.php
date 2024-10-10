<?php

namespace Tests\Feature;

use App\Models\Atendente;
use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AtendenteTest extends TestCase
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

    public function test_can_create_atendente()
    {
        $usuario = Usuario::factory()->create();

        $token = $this->authenticate();

        $data = [
            'id_usuario' => $usuario->id,
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->postJson('/api/atendentes', $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('atendentes', ['id_usuario' => $usuario->id]);
    }

    public function test_can_list_atendentes()
    {
        Atendente::factory()->count(3)->create();

        $token = $this->authenticate();

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->getJson('/api/atendentes');

        $response->assertStatus(200);
        $this->assertCount(3, $response->json());
    }

    public function test_can_show_atendente()
    {
        $atendente = Atendente::factory()->create();

        $token = $this->authenticate();

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->getJson("/api/atendentes/{$atendente->id}");

        $response->assertStatus(200)
            ->assertJson([
                'id' => $atendente->id,
            ]);
    }

    public function test_can_update_atendente()
    {
        $atendente = Atendente::factory()->create();

        $token = $this->authenticate();

        $data = [
            'id_usuario' => $atendente->id_usuario,
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->putJson("/api/atendentes/{$atendente->id}", $data);

        $response->assertStatus(200);
        $this->assertDatabaseHas('atendentes', ['id_usuario' => $atendente->id_usuario]);
    }

    public function test_can_delete_atendente()
    {
        $atendente = Atendente::factory()->create();

        $token = $this->authenticate();

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->deleteJson("/api/atendentes/{$atendente->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('atendentes', ['id' => $atendente->id]);
    }
}
