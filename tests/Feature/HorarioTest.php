<?php

use App\Models\Usuario;
use App\Models\Medico;
use App\Models\Horario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\{get, post, put, delete, actingAs};

uses(RefreshDatabase::class);

// Configuração inicial para autenticação
beforeEach(function () {
    /** @var Usuario $usuario */
    $usuario = Usuario::factory()->create();
    actingAs($usuario, 'api');
});

// Teste de sucesso: cadastro em lote de horários
it('cadastra horários em lote com sucesso', function () {
    $medico = Medico::factory()->create();
    $payload = [
        'horarios' => [
            [
                'id_medico' => $medico->id,
                'horario' => '08:00:00',
                'dia_semana' => 'segunda-feira',
            ],
            [
                'id_medico' => $medico->id,
                'horario' => '09:00:00',
                'dia_semana' => 'terca-feira',
            ],
        ]
    ];

    $response = post('/api/horarios', $payload);
    $response->assertCreated();
    $response->assertJsonFragment([
        'message' => 'Horários cadastrados com sucesso!'
    ]);
    expect(Horario::where('id_medico', $medico->id)->count())->toBe(2);
});

// Teste de falha: campos obrigatórios ausentes
it('retorna erro ao tentar cadastrar horários sem campos obrigatórios', function () {
    $response = post('/api/horarios', [], ['Accept' => 'application/json']);
    $response->assertStatus(422);
    $response->assertJsonFragment([
        'message' => 'The horarios field is required.'
    ]);
});

// Teste de falha: campos obrigatórios inválidos
it('retorna erro ao tentar cadastrar horários com dados inválidos', function () {
    $payload = [
        'horarios' => [
            [
                'id_medico' => 9999, // médico inexistente
                'horario' => '25:00:00', // horário inválido
                'dia_semana' => '', // vazio
            ]
        ]
    ];
    $response = post('/api/horarios', $payload, ['Accept' => 'application/json']);
    // dd($response->json());
    $response->assertStatus(422);
    $response->assertJsonValidationErrors([
        'horarios.0.id_medico',
        'horarios.0.horario',
        'horarios.0.dia_semana',
    ]);
});

// Teste de falha: cadastro de horário duplicado
it('não permite duplicar horarios mas só adiciona os novos que vao no array caso repetidos', function () {
    $medico = Medico::factory()->create();
    // Cria um horário existente
    Horario::create([
        'id_medico' => $medico->id,
        'horario' => '14:00:00',
        'dia_semana' => 'sexta-feira',
        'disponivel' => true,
    ]);
    // Tenta cadastrar o mesmo horário novamente
    $payload = [
        'horarios' => [
            [
                'id_medico' => $medico->id,
                'horario' => '14:00:00',
                'dia_semana' => 'sexta-feira',
            ],
            [
                'id_medico' => $medico->id,
                'horario' => '16:00:00',
                'dia_semana' => 'quinta-feira',
            ]
        ]
    ];
    $response = post('/api/horarios', $payload, ['Accept' => 'application/json']);

    $response->assertStatus(201);
    $response->assertJsonFragment([
        'message' => 'Horários cadastrados com sucesso!'
    ]);
});

// Teste de cadastro em lote ignorando duplicados
it('cadastra apenas horários não duplicados e ignora os já existentes', function () {
    $medico = Medico::factory()->create();
    // Cria um horário já existente
    Horario::create([
        'id_medico' => $medico->id,
        'horario' => '15:00:00',
        'dia_semana' => 'quinta-feira',
        'disponivel' => true,
    ]);
    // Payload com um horário duplicado e um novo
    $payload = [
        'horarios' => [
            [
                'id_medico' => $medico->id,
                'horario' => '15:00:00', // já existe
                'dia_semana' => 'quinta-feira',
            ],
            [
                'id_medico' => $medico->id,
                'horario' => '16:00:00', // novo
                'dia_semana' => 'quinta-feira',
            ]
        ]
    ];
    $response = post('/api/horarios', $payload, ['Accept' => 'application/json']);
    $response->assertCreated();
    $response->assertJsonFragment([
        'message' => 'Horários cadastrados com sucesso!'
    ]);
    expect(Horario::where('id_medico', $medico->id)->where('dia_semana', 'quinta-feira')->count())->toBe(2);
});

// Teste de sucesso: deleção de horário existente
it('deleta um horário existente com sucesso', function () {
    $medico = Medico::factory()->create();
    $horario = Horario::create([
        'id_medico' => $medico->id,
        'horario' => '10:00:00',
        'dia_semana' => 'quarta',
        'disponivel' => true,
    ]);
    $response = delete("/api/horarios/{$horario->id}");
    $response->assertOk();
    $response->assertJsonFragment([
        'message' => 'Horário deletado com sucesso!'
    ]);
    expect(Horario::find($horario->id))->toBeNull();
});

// Teste de falha: deleção de horário inexistente
it('retorna erro ao tentar deletar horário inexistente', function () {
    $response = delete('/api/horarios/99999');
    $response->assertStatus(404);
    $response->assertJsonFragment([
        'message' => 'Horário não encontrado.'
    ]);
});
