<?php

use App\Models\Endereco;
use App\Models\Paciente;
use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\{get, post, put, delete, actingAs};

uses(RefreshDatabase::class);

beforeEach(function () {
    /** @var Usuario $usuario */
    $usuario = Usuario::factory()->create();
    actingAs($usuario, 'api');

    $this->paciente = Paciente::factory()->create();
    $this->endereco = Endereco::factory()->create([
        'id_paciente' => $this->paciente->id,
    ]);
});

it('lista os endereços', function () {
    Endereco::factory()->count(2)->create([
        'id_paciente' => Paciente::factory()->create()->id,
    ]);

    get('/api/enderecos')
        ->assertStatus(200)
        ->assertJsonCount(3);
});

it('exibe um endereço específico', function () {
    get("/api/enderecos/{$this->endereco->id}")
        ->assertStatus(200)
        ->assertJsonFragment(['id' => $this->endereco->id]);
});

it('cria um endereço', function () {
    $data = Endereco::factory()->make([
        'id_paciente' => Paciente::factory()->create()->id,
    ])->toArray();

    post('/api/enderecos', $data)
        ->assertStatus(201)
        ->assertJsonFragment(['cep' => $data['cep']]);
});

it('atualiza um endereço', function () {
    put("/api/enderecos/{$this->endereco->id}", [
        'cep' => '99999999',
        'id_paciente' => $this->paciente->id, // obrigatório pela validação
    ])
        ->assertStatus(200)
        ->assertJsonFragment(['cep' => '99999999']);
});

it('deleta um endereço', function () {
    delete("/api/enderecos/{$this->endereco->id}")
        ->assertStatus(200)
        ->assertJsonFragment(['message' => 'Endereço deletado com sucesso.']);
});
