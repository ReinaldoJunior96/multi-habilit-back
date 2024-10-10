<?php

namespace Tests\Feature;

use App\Models\Paciente;
use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PacienteTest extends TestCase
{
    use RefreshDatabase;

    private $token;

    /**
     * Autentica o usuário e armazena o token JWT.
     */
    protected function setUp(): void
    {
        parent::setUp();

        // Cria um usuário e faz o login
        $usuario = Usuario::factory()->create([
            'email' => 'admin@example.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'admin@example.com',
            'password' => 'password123',
        ]);

        $this->token = $response->json('token'); // Armazena o token JWT para ser usado nos testes
    }

    /**
     * Testa a criação de um paciente.
     */
    public function test_can_create_paciente()
    {
        $usuario = Usuario::factory()->create();

        $data = [
            'estado_civil' => 'Solteiro',
            'nome_mae' => 'Maria Silva',
            'nome_pai' => 'João Silva',
            'prefrencial' => false,
            'cns' => '12345678910',
            'nome_conjuge' => 'Nenhum',
            'cor_raca' => 'Branco',
            'profissao' => 'Professor',
            'instrucao' => 'Superior',
            'nacionalidade' => 'Brasileiro',
            'tipo_sanguineo' => 'O+',
            'id_usuario' => $usuario->id,
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->postJson('/api/pacientes', $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('pacientes', ['nome_mae' => 'Maria Silva']);
    }

    /**
     * Testa a listagem de pacientes.
     */
    public function test_can_list_pacientes()
    {
        Paciente::factory()->count(3)->create();

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->getJson('/api/pacientes');

        $response->assertStatus(200);
        $this->assertCount(3, $response->json());
    }

    /**
     * Testa a exibição de um paciente.
     */
    public function test_can_show_paciente()
    {
        $paciente = Paciente::factory()->create();

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->getJson("/api/pacientes/{$paciente->id}");

        $response->assertStatus(200)
            ->assertJsonFragment([
                'id' => $paciente->id,
                'nome_mae' => $paciente->nome_mae,
            ]);
    }

    /**
     * Testa a atualização de um paciente.
     */
    public function test_can_update_paciente()
    {
        $paciente = Paciente::factory()->create();

        $data = [
            'estado_civil' => 'Casado',
            'nome_mae' => $paciente->nome_mae,
            'prefrencial' => $paciente->prefrencial,
            'id_usuario' => $paciente->id_usuario,
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->putJson("/api/pacientes/{$paciente->id}", $data);

        $response->assertStatus(200);
        $this->assertDatabaseHas('pacientes', ['estado_civil' => 'Casado']);
    }

    /**
     * Testa a exclusão de um paciente.
     */
    public function test_can_delete_paciente()
    {
        $paciente = Paciente::factory()->create();

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->deleteJson("/api/pacientes/{$paciente->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('pacientes', ['id' => $paciente->id]);
    }
}
