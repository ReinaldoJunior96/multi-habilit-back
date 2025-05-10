<?php

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

it('deve listar todos os orçamentos', function () {
    \App\Models\Orcamento::factory()->count(3)->create();

    get('/api/orcamentos')
        ->assertStatus(200)
        ->assertJsonCount(3);
});

it('deve criar um orçamento', function () {
    $data = [
        'nome_paciente' => 'João Silva',
        'tipo_servico' => 'Fisioterapia',
        'numero_sessoes' => 10,
        'valor_unitario' => 150.50,
        'desconto' => 10.00,
        'observacoes' => 'Paciente com histórico de lesão no joelho.',
    ];

    post('/api/orcamentos', $data)
        ->assertStatus(201)
        ->assertJsonFragment(['nome_paciente' => 'João Silva']);
});

it('deve exibir um orçamento específico', function () {
    $orcamento = \App\Models\Orcamento::factory()->create();

    get("/api/orcamentos/{$orcamento->id}")
        ->assertStatus(200)
        ->assertJsonFragment(['id' => $orcamento->id]);
});

it('deve atualizar um orçamento', function () {
    $orcamento = \App\Models\Orcamento::factory()->create();

    $data = [
        'nome_paciente' => 'Maria Oliveira',
        'tipo_servico' => 'Pilates',
        'numero_sessoes' => 15,
        'valor_unitario' => 200.00,
        'desconto' => 5.00,
        'observacoes' => 'Paciente com recomendação médica.',
    ];

    put("/api/orcamentos/{$orcamento->id}", $data)
        ->assertStatus(200)
        ->assertJsonFragment(['nome_paciente' => 'Maria Oliveira']);
});

it('deve deletar um orçamento', function () {
    $orcamento = \App\Models\Orcamento::factory()->create();

    delete("/api/orcamentos/{$orcamento->id}")
        ->assertStatus(200)
        ->assertJsonFragment(['message' => 'Orçamento deletado com sucesso.']);
});
