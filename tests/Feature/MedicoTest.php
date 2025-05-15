<?php

use App\Models\Medico;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\{get, post, put, delete};

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create(); // cria usuário fake
    $this->medico = Medico::factory()->create();
});

it('deve listar todos os médicos', function () {
    $this->actingAs($this->user, 'api');

    Medico::factory()->count(5)->create();

    get('/api/medicos')
        ->assertStatus(200)
        ->assertJsonCount(6); // Inclui o médico criado no beforeEach
});

it('deve criar um novo médico', function () {
    $this->actingAs($this->user, 'api');

    $data = Medico::factory()->make()->toArray();

    post('/api/medicos', $data)
        ->assertStatus(201)
        ->assertJsonFragment([
            'nome_completo' => $data['nome_completo'],
            'email' => $data['email'],
            'cpf' => $data['cpf'],
            'regime_trabalhista' => $data['regime_trabalhista'],
        ]);
});

it('não deve criar médico sem campos obrigatórios', function () {
    $this->actingAs($this->user, 'api');
    $response = post('/api/medicos', []);
    $response->assertStatus(422)
        ->assertJsonValidationErrors([
            'nome_completo',
            'email',
            'cpf',
            'tipo',
        ])
        ->assertJsonPath('errors.nome_completo.0', 'O nome completo é obrigatório.')
        ->assertJsonPath('errors.email.0', 'O e-mail é obrigatório.')
        ->assertJsonPath('errors.cpf.0', 'O CPF é obrigatório.')
        ->assertJsonPath('errors.tipo.0', 'O tipo é obrigatório.');
});

it('deve exibir um médico específico', function () {
    $this->actingAs($this->user, 'api');

    get("/api/medicos/{$this->medico->id}")
        ->assertStatus(200)
        ->assertJsonFragment([
            'id' => $this->medico->id,
            'nome_completo' => $this->medico->nome_completo,
        ]);
});

it('deve atualizar um médico existente', function () {
    $this->actingAs($this->user, 'api');

    $data = [
        'nome_completo' => 'Nome Atualizado',
        'email' => 'atualizado@example.com',
        'data_nascimento' => '1990-01-01',
        'sexo' => 'Masculino',
        'cpf' => '12345678901',
        'telefone' => '11999999999',
        'tipo' => 'terapeuta',
        'regime_trabalhista' => 1,
        'carga_horaria' => 30,
        'cnpj' => '12345678000123',
    ];

    put("/api/medicos/{$this->medico->id}", $data)
        ->assertStatus(200)
        ->assertJsonFragment([
            'nome_completo' => 'Nome Atualizado',
            'email' => 'atualizado@example.com',
            'cpf' => '12345678901',
            'regime_trabalhista' => 1,
        ]);
});

it('não deve atualizar médico com dados inválidos', function () {
    $this->actingAs($this->user, 'api');
    $data = [
        'nome_completo' => '',
        'email' => 'email-invalido',
        'cpf' => '',
        'tipo' => '',
    ];
    $response = put("/api/medicos/{$this->medico->id}", $data);
    $response->assertStatus(422)
        ->assertJsonValidationErrors([
            'nome_completo',
            'email',
            'cpf',
            'tipo',
        ]);
});

it('deve deletar um médico', function () {
    $this->actingAs($this->user, 'api');

    delete("/api/medicos/{$this->medico->id}")
        ->assertStatus(200)
        ->assertJsonFragment(['message' => 'Médico deletado com sucesso.']);
    $this->assertDatabaseMissing('medicos', ['id' => $this->medico->id]);
});
