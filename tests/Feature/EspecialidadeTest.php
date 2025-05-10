<?php

use App\Models\Procedimento;
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

it('deve listar todas as especialidades', function () {
    \App\Models\Especialidade::factory()->count(3)->create();

    get('/api/especialidades')
        ->assertStatus(200)
        ->assertJsonCount(3);
});

it('deve criar uma especialidade', function () {
    $data = [
        'nome' => 'Cardiologia',
        'descricao' => 'Especialidade médica focada no coração.',
        'cor' => '#FF5733',
        'id_procedimento' => Procedimento::factory()->create()->id,
        'ativa' => true,
    ];

    post('/api/especialidades', $data)
        ->assertStatus(201)
        ->assertJsonFragment(['nome' => 'Cardiologia']);
});

it('deve exibir uma especialidade específica', function () {
    $especialidade = \App\Models\Especialidade::factory()->create();

    get("/api/especialidades/{$especialidade->id}")
        ->assertStatus(200)
        ->assertJsonFragment(['id' => $especialidade->id]);
});

it('deve atualizar uma especialidade', function () {
    $especialidade = \App\Models\Especialidade::factory()->create();

    $data = [
        'nome' => 'Neurologia',
        'descricao' => 'Especialidade médica focada no sistema nervoso.',
        'cor' => '#33FF57',
        'id_procedimento' => Procedimento::factory()->create()->id,
        'ativa' => false,
    ];

    put("/api/especialidades/{$especialidade->id}", $data)
        ->assertStatus(200)
        ->assertJsonFragment(['nome' => 'Neurologia']);
});

it('deve deletar uma especialidade', function () {
    $especialidade = \App\Models\Especialidade::factory()->create();

    delete("/api/especialidades/{$especialidade->id}")
        ->assertStatus(200)
        ->assertJsonFragment(['message' => 'Especialidade deletada com sucesso.']);
});

it('deve retornar todos os procedimentos de uma especialidade', function () {
    $especialidade = \App\Models\Especialidade::factory()->create();

    $procedimentos = Procedimento::factory()->count(3)->create(['id_especialidade' => $especialidade->id]);

    get("/api/especialidades/{$especialidade->id}")
        ->assertStatus(200)
        ->assertJsonFragment(['id' => $especialidade->id])
        ->assertJsonFragment(['id' => $procedimentos->first()->id])
        ->assertJsonCount(3, 'procedimentos');
});
