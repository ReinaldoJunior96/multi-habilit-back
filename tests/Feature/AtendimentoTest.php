<?php

use App\Models\Atendimento;
use App\Models\Usuario;
use App\Models\Paciente;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\{get, post, put, delete, actingAs};

uses(RefreshDatabase::class);

beforeEach(function () {

    /** @var Usuario $usuario */
    $usuario = Usuario::factory()->create();
    actingAs($usuario, 'api');


    $this->paciente = Paciente::factory()->create();
    $this->atendimento = Atendimento::factory()->create([
        'id_paciente' => $this->paciente->id,
    ]);
});

it('deve listar todos os atendimentos', function () {
    Atendimento::factory()->count(3)->create([
        'id_paciente' => $this->paciente->id,
    ]);

    get('/api/atendimentos')
        ->assertStatus(200)
        ->assertJsonCount(4); // já inclui o atendimento criado no beforeEach
});

it('deve criar um atendimento', function () {
    $data = [
        'id_paciente' => $this->paciente->id,
        'encaminhador' => 'Dr. Silva',
        'convenio' => 'Unimed',
    ];

    post('/api/atendimentos', $data)
        ->assertStatus(201)
        ->assertJsonFragment(['encaminhador' => 'Dr. Silva']);
});

it('deve exibir um atendimento específico', function () {
    get("/api/atendimentos/{$this->atendimento->id}")
        ->assertStatus(200)
        ->assertJsonFragment(['id' => $this->atendimento->id]);
});

it('deve atualizar um atendimento', function () {
    $data = [
        'encaminhador' => 'Atualizado',
        'id_paciente' => $this->paciente->id, // garantir que passe na validação
    ];

    put("/api/atendimentos/{$this->atendimento->id}", $data)
        ->assertStatus(200)
        ->assertJsonFragment(['encaminhador' => 'Atualizado']);
});

it('deve deletar um atendimento', function () {
    delete("/api/atendimentos/{$this->atendimento->id}")
        ->assertStatus(200)
        ->assertJsonFragment(['message' => 'Atendimento deletado com sucesso.']);
});
