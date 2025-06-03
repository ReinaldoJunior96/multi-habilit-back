<?php

use App\Models\ContaAPagar;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\{get, post, put, delete};

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user, 'api');
});

it('cria uma conta a pagar com sucesso', function () {
    $payload = ContaAPagar::factory()->make()->toArray();
    $response = post('/api/contas-a-pagar', $payload, ['Accept' => 'application/json']);
    $response->assertStatus(201)
        ->assertJsonFragment([
            'descricao' => $payload['descricao'],
            'categoria' => $payload['categoria'],
            'valor' => $payload['valor'],
            'status' => $payload['status'],
            'tipo' => $payload['tipo'],
        ]);
});

it('não cria conta a pagar sem campos obrigatórios', function () {
    $response = post('/api/contas-a-pagar', [], ['Accept' => 'application/json']);
    $response->assertStatus(422)
        ->assertJsonValidationErrors(['descricao', 'categoria', 'valor', 'vencimento', 'status', 'tipo']);
});

it('lista contas a pagar', function () {
    $conta = ContaAPagar::factory()->create();
    $response = get('/api/contas-a-pagar');
    $response->assertStatus(200)
        ->assertJsonPath('data.0.id', $conta->id);
});

it('mostra uma conta a pagar específica', function () {
    $conta = ContaAPagar::factory()->create();
    $response = get("/api/contas-a-pagar/{$conta->id}");
    $response->assertStatus(200)
        ->assertJsonPath('data.id', $conta->id);
});

it('atualiza uma conta a pagar', function () {
    $conta = ContaAPagar::factory()->create();
    $payload = [
        'descricao' => 'Conta Atualizada',
        'categoria' => 'Internet',
        'valor' => 123.45,
        'vencimento' => now()->addMonth()->format('Y-m-d'),
        'status' => 'pago',
        'tipo' => 'fixa',
    ];
    $response = put("/api/contas-a-pagar/{$conta->id}", $payload, ['Accept' => 'application/json']);
    $response->assertStatus(200)
        ->assertJsonFragment([
            'descricao' => 'Conta Atualizada',
            'categoria' => 'Internet',
            'valor' => 123.45,
            'status' => 'pago',
            'tipo' => 'fixa',
        ]);
});

it('deleta uma conta a pagar', function () {
    $conta = ContaAPagar::factory()->create();
    $response = delete("/api/contas-a-pagar/{$conta->id}");
    $response->assertStatus(200)
        ->assertJsonFragment(['message' => 'Conta a pagar deletada com sucesso.']);
    $this->assertDatabaseMissing('contas_a_pagar', ['id' => $conta->id]);
});
