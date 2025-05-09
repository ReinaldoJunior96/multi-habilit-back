<?php

use App\Models\Convenio;
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

// Teste para listar todos os convênios
it('lista todos os convênios', function () {
    Convenio::factory()->count(3)->create();

    get('/api/convenios')
        ->assertStatus(200)
        ->assertJsonCount(3);
});

// Teste para criar um novo convênio
it('cria um convênio com sucesso', function () {
    $data = Convenio::factory()->make()->toArray();

    post('/api/convenios', $data)
        ->assertStatus(201)
        ->assertJsonFragment(['descricao' => $data['descricao']]);
});

// Teste para exibir um convênio específico
it('exibe um convênio específico', function () {
    $convenio = Convenio::factory()->create();

    get("/api/convenios/{$convenio->id}")
        ->assertStatus(200)
        ->assertJsonFragment(['id' => $convenio->id]);
});

// Teste para atualizar um convênio existente
it('atualiza um convênio com sucesso', function () {
    $convenio = Convenio::factory()->create([
        'descricao' => 'Descrição Antiga',
    ]);

    $novaDescricao = 'Descrição Atualizada';
    put("/api/convenios/{$convenio->id}", ['descricao' => $novaDescricao])
        ->assertStatus(200)
        ->assertJsonFragment(['descricao' => $novaDescricao]);
});

// Teste para remover um convênio
it('remove um convênio com sucesso', function () {
    $convenio = Convenio::factory()->create();

    delete("/api/convenios/{$convenio->id}")
        ->assertStatus(200)
        ->assertJsonFragment(['message' => 'Convênio removido com sucesso.']);
});

// Teste para listar procedimentos de um convênio
it('lista procedimentos de um convênio', function () {
    $convenio = Convenio::factory()->create();
    $procedimentos = \App\Models\Procedimento::factory()->count(2)->create(['id_convenio' => $convenio->id]);
    get("/api/convenios/{$convenio->id}/procedimentos")
        ->assertStatus(200)
        ->assertJsonCount(2);
});
