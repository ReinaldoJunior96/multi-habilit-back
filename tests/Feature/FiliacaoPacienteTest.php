<?php

use App\Models\FiliacaoPaciente;
use App\Models\Paciente;
use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\{get, post, put, delete, actingAs};

uses(RefreshDatabase::class);

beforeEach(function () {
    /** @var Usuario $usuario */
    $usuario = Usuario::factory()->create();
    actingAs($usuario, 'api');
});

it('cria uma filiação de paciente', function () {
    $paciente = Paciente::factory()->create();

    $data = FiliacaoPaciente::factory()->make([
        'id_paciente' => $paciente->id,
    ])->toArray();

    $response = $this->post('/api/filiacao-paciente', $data);
    $response->assertStatus(201);
    // $this->assertDatabaseHas('filiacao_paciente', ['cpf_pai' => $data['cpf_pai']]);
});

it('lista filiações de pacientes', function () {
    FiliacaoPaciente::factory()->count(3)->create();

    $response = $this->get('/api/filiacao-paciente');

    $response->assertStatus(200);
    $response->assertJsonCount(3);
});

it('atualiza uma filiação de paciente', function () {
    $filiacao = FiliacaoPaciente::factory()->create();

    $novoEmailPai = 'novoemail@teste.com';
    $response = $this->put("/api/filiacao-paciente/{$filiacao->id}", [
        'email_pai' => $novoEmailPai,
    ]);

    $response->assertStatus(200);
    $this->assertDatabaseHas('filiacao_paciente', ['id' => $filiacao->id, 'email_pai' => $novoEmailPai]);
});

it('deleta uma filiação de paciente', function () {
    $filiacao = FiliacaoPaciente::factory()->create();

    $response = $this->delete("/api/filiacao-paciente/{$filiacao->id}");

    $response->assertStatus(204);
    $this->assertDatabaseMissing('filiacao_paciente', ['id' => $filiacao->id]);
});
