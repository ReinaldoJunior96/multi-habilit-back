<?php

use App\Models\Atendimento;
use App\Models\Paciente;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\{get, post, put, delete};

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->paciente = Paciente::factory()->create();
    $this->atendimento = Atendimento::factory()->create([
        'id_paciente' => $this->paciente->id,
    ]);
});

it('returns a successful response', function () {
    $response = $this->get('/');
    $response->assertStatus(200);
});

it('deve listar atendimentos', function () {
    Atendimento::factory()->count(3)->create([
        'id_paciente' => $this->paciente->id,
    ]);

    get('/api/atendimentos')
        ->assertStatus(200)
        ->assertJsonCount(4); // já inclui o atendimento criado no beforeEach
});

it('deve criar um atendimento', function () {
    $paciente = Paciente::factory()->create();

    $data = [
        'id_paciente' => $paciente->id,
        'encaminhador' => 'Dr. Silva',
        'convenio' => 'Unimed',
    ];

    post('/api/atendimentos', $data)
        ->assertStatus(201)
        ->assertJsonFragment(['encaminhador' => 'Dr. Silva']);
});

it('deve mostrar um atendimento', function () {
    get("/api/atendimentos/{$this->atendimento->id}")
        ->assertStatus(200)
        ->assertJsonFragment(['id' => $this->atendimento->id]);
});

it('deve atualizar um atendimento', function () {
    put("/api/atendimentos/{$this->atendimento->id}", [
        'encaminhador' => 'Atualizado',
        'id_paciente' => $this->paciente->id, // garantir que passe na validação
    ])
        ->assertStatus(200)
        ->assertJsonFragment(['encaminhador' => 'Atualizado']);
});

it('deve deletar um atendimento', function () {
    delete("/api/atendimentos/{$this->atendimento->id}")
        ->assertStatus(200)
        ->assertJsonFragment(['message' => 'Atendimento deletado com sucesso']);
});
