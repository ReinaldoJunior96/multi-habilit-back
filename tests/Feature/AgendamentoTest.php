<?php

use App\Models\Agendamento;
use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\{actingAs, get, post, put, delete};

uses(RefreshDatabase::class);

beforeEach(function () {
    /** @var Usuario $usuario */
    $usuario = Usuario::factory()->create();
    actingAs($usuario, 'api');

    $this->agendamento = Agendamento::factory()->create();
});

it('lista os agendamentos', function () {
    Agendamento::factory()->count(2)->create();
    get('/api/agendamentos')
        ->assertStatus(200)
        ->assertJsonStructure([
            '*' => ['id', 'atendente', 'paciente', 'medico_id', 'data_agendada', 'status']
        ]);
});

it('exibe um agendamento específico', function () {
    get("/api/agendamentos/{$this->agendamento->id}")
        ->assertStatus(200)
        ->assertJsonFragment(['id' => $this->agendamento->id]);
});

it('cria um agendamento', function () {
    $data = Agendamento::factory()->make()->toArray();
    $data['data_agendada'] = $data['data_agendada']->format('Y-m-d H:i:s');

    post('/api/agendamentos', $data)
        ->assertStatus(201)
        ->assertJsonFragment(['atendente' => $data['atendente']]);
});


it('atualiza um agendamento', function () {
    put("/api/agendamentos/{$this->agendamento->id}", [
        'unidade' => 'Unidade Atualizada',
        'status' => 1,
        'atendente' => $this->agendamento->atendente,
        'paciente' => $this->agendamento->paciente,
        'medico_id' => $this->agendamento->medico_id,
        'convenio' => $this->agendamento->convenio,
        'data_agendada' => now()->addDays(5)->format('Y-m-d H:i:s'),
    ])
        ->assertStatus(200)
        ->assertJsonFragment(['unidade' => 'Unidade Atualizada']);
});

it('deleta um agendamento', function () {
    delete("/api/agendamentos/{$this->agendamento->id}")
        ->assertStatus(200)
        ->assertJsonFragment(['message' => 'Agendamento deletado com sucesso.']);
});
