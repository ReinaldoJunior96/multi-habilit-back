<?php

use App\Models\Paciente;
use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\{get, post, put, delete, actingAs};

uses(RefreshDatabase::class);

// Configuração inicial para autenticação
beforeEach(function () {
    /** @var Usuario $usuario */
    $usuario = Usuario::factory()->create();
    actingAs($usuario, 'api');
});

it('lista todos os pacientes', function () {
    Paciente::factory()->count(3)->create();

    get('/api/pacientes')
        ->assertStatus(200)
        ->assertJsonCount(3);
});

it('exibe um paciente específico', function () {
    $paciente = Paciente::factory()->create();

    get("/api/pacientes/{$paciente->id}")
        ->assertStatus(200)
        ->assertJsonFragment(['id' => $paciente->id]);
});

it('cria um novo paciente', function () {
    $data = Paciente::factory()->make()->toArray();

    post('/api/pacientes', $data)
        ->assertStatus(201)
        ->assertJsonFragment(['nome' => $data['nome']]);
});

it('atualiza um paciente existente', function () {
    $paciente = Paciente::factory()->create();

    $novoNome = 'Nome Atualizado';
    put("/api/pacientes/{$paciente->id}", ['nome' => $novoNome])
        ->assertStatus(200)
        ->assertJsonFragment(['nome' => $novoNome]);
});

it('remove um paciente', function () {
    $paciente = Paciente::factory()->create();

    delete("/api/pacientes/{$paciente->id}")
        ->assertStatus(200)
        ->assertJsonFragment(['message' => 'Paciente removido com sucesso.']);
});

it('busca um paciente pelo CPF', function () {
    $paciente = Paciente::factory()->create(['cpf' => '12345678901']);

    get('/api/pacientes/cpf/12345678901')
        ->assertStatus(200)
        ->assertJsonFragment(['cpf' => '12345678901']);
});

it('retorna erro ao buscar paciente inexistente pelo CPF', function () {
    get('/api/pacientes/cpf/00000000000')
        ->assertStatus(404)
        ->assertJsonFragment(['message' => 'Paciente não encontrado.']);
});
