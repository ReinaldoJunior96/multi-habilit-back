<?php

use App\Models\Convenio;
use App\Models\Procedimento;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\{get, post, put, delete};

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create(); // cria usuário fake
    $this->convenio = Convenio::factory()->create();

    $this->procedimento = Procedimento::factory()->create([
        'id_convenio' => $this->convenio->id,
    ]);
});

it('deve listar todos os procedimentos', function () {
    $this->actingAs($this->user, 'api');

    Procedimento::factory()->count(5)->create(['id_convenio' => $this->convenio->id]);

    get('/api/procedimentos')
        ->assertStatus(200)
        ->assertJsonCount(6);
});

it('deve criar um novo procedimento', function () {
    $this->actingAs($this->user, 'api');

    $data = Procedimento::factory()->make(['id_convenio' => $this->convenio->id])->toArray();

    post('/api/procedimentos', $data)
        ->assertStatus(201)
        ->assertJsonFragment(['procedimento' => $data['procedimento']]);
});

it('deve exibir um procedimento específico', function () {
    $this->actingAs($this->user, 'api');

    get("/api/procedimentos/{$this->procedimento->id}")
        ->assertStatus(200)
        ->assertJsonFragment(['id' => $this->procedimento->id]);
});

it('deve atualizar um procedimento existente', function () {
    $this->actingAs($this->user, 'api');

    $data = ['procedimento' => 'Procedimento Atualizado', 'id_convenio' => $this->convenio->id];

    put("/api/procedimentos/{$this->procedimento->id}", $data)
        ->assertStatus(200)
        ->assertJsonFragment(['procedimento' => 'Procedimento Atualizado']);
});

it('deve deletar um procedimento', function () {
    $this->actingAs($this->user, 'api');

    delete("/api/procedimentos/{$this->procedimento->id}")
        ->assertStatus(200)
        ->assertJsonFragment(['message' => 'Procedimento deletado com sucesso.']);
});

it('deve deletar o procedimento ao deletar o convênio associado', function () {
    $this->actingAs($this->user, 'api');

    $procedimento = Procedimento::factory()->create(['id_convenio' => $this->convenio->id]);

    delete("/api/convenios/{$this->convenio->id}")
        ->assertStatus(200)
        ->assertJsonFragment(['message' => 'Convênio removido com sucesso.']);

    $this->assertDatabaseMissing('procedimentos', ['id' => $procedimento->id]);
});

it('deve verificar o relacionamento de procedimento com especialidade', function () {
    $this->actingAs($this->user, 'api');

    $especialidade = \App\Models\Especialidade::factory()->create();


    $this->procedimento->update(['id_especialidade' => $especialidade->id]);

    get("/api/procedimentos/{$this->procedimento->id}")
        ->assertStatus(200)
        ->assertJsonFragment(['id' => $this->procedimento->id])
        ->assertJsonFragment(['id_especialidade' => $especialidade->id]);
});
