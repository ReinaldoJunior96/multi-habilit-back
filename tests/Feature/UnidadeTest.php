<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\{get, post, put, delete};

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user, 'api');
});

// Teste de CRUD completo de Unidade
it('cria uma unidade com sucesso', function () {
    $endereco = \App\Models\Endereco::factory()->create();
    $payload = [
        'nome' => 'Unidade Teste',
        'id_endereco' => $endereco->id,
        'telefone' => '11999999999',
        'email' => 'unidade@teste.com',
        'cnpj' => '12345678000199',
        'responsavel' => 'Responsável Teste',
        'horario_funcionamento' => '08:00-18:00',
        'status' => 'ativo',
        'tipo' => 'matriz',
    ];
    $response = post('/api/unidades', $payload, ['Accept' => 'application/json']);
    $response->assertStatus(201)
        ->assertJsonFragment([
            'nome' => 'Unidade Teste',
            'id_endereco' => $endereco->id,
            'email' => 'unidade@teste.com',
        ]);
});

it('não cria unidade sem campos obrigatórios', function () {
    $response = post('/api/unidades', [], ['Accept' => 'application/json']);
    $response->assertStatus(422)
        ->assertJsonValidationErrors(['nome', 'id_endereco']);
});

it('lista unidades', function () {
    $endereco = \App\Models\Endereco::factory()->create();
    $unidade = \App\Models\Unidade::factory()->create(['id_endereco' => $endereco->id]);
    $response = get('/api/unidades');
    $response->assertStatus(200)
        ->assertJsonPath('data.0.endereco.id', $endereco->id);
});

it('mostra uma unidade específica', function () {
    $endereco = \App\Models\Endereco::factory()->create();
    $unidade = \App\Models\Unidade::factory()->create(['id_endereco' => $endereco->id]);
    $response = get("/api/unidades/{$unidade->id}");
    $response->assertStatus(200)
        ->assertJsonPath('data.endereco.id', $endereco->id)
        ->assertJsonPath('data.id', $unidade->id);
});

it('atualiza uma unidade', function () {
    $endereco = \App\Models\Endereco::factory()->create();
    $unidade = \App\Models\Unidade::factory()->create(['id_endereco' => $endereco->id]);
    $payload = [
        'nome' => 'Unidade Atualizada',
        'id_endereco' => $endereco->id,
        'telefone' => '11988888888',
        'email' => 'nova@unidade.com',
        'cnpj' => '12345678000188',
        'responsavel' => 'Novo Responsável',
        'horario_funcionamento' => '09:00-19:00',
        'status' => 'inativo',
        'tipo' => 'filial',
    ];
    $response = put("/api/unidades/{$unidade->id}", $payload, ['Accept' => 'application/json']);
    $response->assertStatus(200)
        ->assertJsonFragment([
            'nome' => 'Unidade Atualizada',
            'email' => 'nova@unidade.com',
            'status' => 'inativo',
        ]);
});

it('deleta uma unidade', function () {
    $endereco = \App\Models\Endereco::factory()->create();
    $unidade = \App\Models\Unidade::factory()->create(['id_endereco' => $endereco->id]);
    $response = delete("/api/unidades/{$unidade->id}");
    $response->assertStatus(200)
        ->assertJsonFragment(['message' => 'Unidade deletada com sucesso.']);
    $this->assertDatabaseMissing('unidades', ['id' => $unidade->id]);
});
