<?php

use App\Models\FichaMedica;
use App\Models\Paciente;
use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\{get, post, put, delete, actingAs};

uses(RefreshDatabase::class);


beforeEach(function () {
    /** @var Usuario $usuario */
    $usuario = Usuario::factory()->create();
    actingAs($usuario, 'api');
});


// Create
it('cria uma ficha médica com sucesso', function () {
    $paciente = Paciente::factory()->create();

    $payload = [
        'id_paciente' => $paciente->id,
        'ficha' => [
            'altura' => 1.75,
            'peso' => 70,
            'historico' => 'Paciente saudável',
            'nome' => 'aaaaa',
            'idade' => 'bbbbbb',
        ]
    ];

    $response = post('/api/fichas-medicas', $payload);

    $response->assertStatus(201);
    expect(FichaMedica::count())->toBe(1);

    $ficha = FichaMedica::first();
    expect($ficha->ficha['nome'])->toBe('aaaaa');
    expect($ficha->ficha['idade'])->toBe('bbbbbb');
});

// Read
it('lista as fichas médicas', function () {
    FichaMedica::factory()->count(3)->create();

    $response = get('/api/fichas-medicas');

    $response->assertStatus(200)
        ->assertJsonCount(3);
});

// Update
it('atualiza uma ficha médica', function () {
    $ficha = FichaMedica::factory()->create([
        'ficha' => ['peso' => 60]
    ]);

    $response = put("/api/fichas-medicas/{$ficha->id}", [
        'ficha' => ['peso' => 65]
    ]);

    $response->assertStatus(200);
    expect($ficha->fresh()->ficha['peso'])->toBe(65);
});

// Delete
it('remove uma ficha médica', function () {
    $ficha = FichaMedica::factory()->create();

    $response = delete("/api/fichas-medicas/{$ficha->id}");

    $response->assertStatus(204);
    expect(FichaMedica::find($ficha->id))->toBeNull();
});
