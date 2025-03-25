<?php

use App\Models\Paciente;
use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\{get, post, put, delete};
use function Pest\Laravel\actingAs;

uses(RefreshDatabase::class);

// Criar um paciente base para os testes
beforeEach(function () {
    /** @var Usuario $usuario */
    $usuario = Usuario::factory()->create();
    actingAs($usuario, 'api');
});

it('lista os pacientes', function () {
    Paciente::factory()->count(2)->create();
    get('/api/pacientes')->assertStatus(200)->assertJsonCount(2);
});

it('cria um paciente', function () {
    $data = Paciente::factory()->make()->toArray();
    post('/api/pacientes', $data)
        ->assertStatus(201)
        ->assertJsonFragment(['nome' => $data['nome']]);
});

it('exibe um paciente específico', function () {
    $paciente = Paciente::factory()->create();
    get("/api/pacientes/{$paciente->id}")
        ->assertStatus(200)
        ->assertJsonFragment(['id' => $paciente->id]);
});

it('atualiza um paciente', function () {
    $paciente = Paciente::factory()->create();
    put("/api/pacientes/{$paciente->id}", ['nome' => 'Atualizado'])
        ->assertStatus(200)
        ->assertJsonFragment(['nome' => 'Atualizado']);
});

it('deleta um paciente', function () {
    $paciente = Paciente::factory()->create();
    delete("/api/pacientes/{$paciente->id}")
        ->assertStatus(200)
        ->assertJsonFragment(['message' => 'Paciente removido com sucesso.']);
});
