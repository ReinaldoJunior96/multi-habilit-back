<?php

use App\Models\FichaMedica;
use App\Models\Paciente;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);


// beforeEach(function () {
//     /** @var Usuario $usuario */
//     $usuario = Usuario::factory()->create();
//     actingAs($usuario, 'api');
// });


// Create
it('cria uma ficha médica com sucesso', function () {
    $paciente = Paciente::factory()->create();

    $payload = [
        'paciente_id' => $paciente->id,
        'ficha' => [
            'altura' => 1.75,
            'peso' => 70,
            'historico' => 'Paciente saudável',
            'nome' => 'aaaaa',
            'idade' => 'bbbbbb',
        ]
    ];

    $response = $this->postJson('/api/fichas-medicas', $payload);

    $response->assertStatus(201);
    expect(FichaMedica::count())->toBe(1);

    $ficha = FichaMedica::first();
    expect($ficha->ficha['nome'])->toBe('aaaaa');
    expect($ficha->ficha['idade'])->toBe('bbbbbb');
});

// Read
it('lista as fichas médicas', function () {
    FichaMedica::factory()->count(3)->create();

    $response = $this->getJson('/api/fichas-medicas');

    $response->assertStatus(200)
        ->assertJsonCount(3);
});

// Update
it('atualiza uma ficha médica', function () {
    $ficha = FichaMedica::factory()->create([
        'ficha' => ['peso' => 60]
    ]);

    $response = $this->putJson("/api/fichas-medicas/{$ficha->id}", [
        'ficha' => ['peso' => 65]
    ]);

    $response->assertStatus(200);
    expect($ficha->fresh()->ficha['peso'])->toBe(65);
});

// Delete
it('remove uma ficha médica', function () {
    $ficha = FichaMedica::factory()->create();

    $response = $this->deleteJson("/api/fichas-medicas/{$ficha->id}");

    $response->assertStatus(204);
    expect(FichaMedica::find($ficha->id))->toBeNull();
});
