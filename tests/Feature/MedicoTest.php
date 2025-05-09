
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
        ->assertJsonFragment(['nome' => $data['nome']]);
});

it('deve exibir um médico específico', function () {
    $this->actingAs($this->user, 'api');

    get("/api/medicos/{$this->medico->id}")
        ->assertStatus(200)
        ->assertJsonFragment(['id' => $this->medico->id]);
});

it('deve atualizar um médico existente', function () {
    $this->actingAs($this->user, 'api');

    $data = ['nome' => 'Médico Atualizado'];

    put("/api/medicos/{$this->medico->id}", $data)
        ->assertStatus(200)
        ->assertJsonFragment(['nome' => 'Médico Atualizado']);
});

it('deve deletar um médico', function () {
    $this->actingAs($this->user, 'api');

    delete("/api/medicos/{$this->medico->id}")
        ->assertStatus(200)
        ->assertJsonFragment(['message' => 'Médico deletado com sucesso.']);
});
