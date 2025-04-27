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

it('deve listar procedimentos', function () {
    $this->actingAs($this->user, 'api'); // simula login no guard api

    Procedimento::factory()->count(3)->create([
        'id_convenio' => $this->convenio->id,
    ]);

    get('/api/procedimentos')
        ->assertStatus(200);
});

it('deve criar um procedimento', function () {
    $this->actingAs($this->user, 'api');

    $data = Procedimento::factory()->make([
        'id_convenio' => $this->convenio->id,
    ])->toArray();

    post('/api/procedimentos', $data)
        ->assertStatus(201)
        ->assertJsonFragment(['procedimento' => $data['procedimento']]);
});

it('deve mostrar um procedimento', function () {
    $this->actingAs($this->user, 'api');

    get("/api/procedimentos/{$this->procedimento->id}")
        ->assertStatus(200)
        ->assertJsonFragment(['id' => $this->procedimento->id]);
});

it('deve atualizar um procedimento', function () {
    $this->actingAs($this->user, 'api');

    $data = [
        'procedimento' => 'Procedimento Atualizado',
        'id_convenio' => $this->convenio->id,
    ];

    put("/api/procedimentos/{$this->procedimento->id}", array_merge($this->procedimento->toArray(), $data))
        ->assertStatus(200)
        ->assertJsonFragment(['procedimento' => 'Procedimento Atualizado']);
});

it('deve deletar um procedimento', function () {
    $this->actingAs($this->user, 'api');

    delete("/api/procedimentos/{$this->procedimento->id}")
        ->assertStatus(200)
        ->assertJsonFragment(['message' => 'Procedimento deletado com sucesso.']);
});
