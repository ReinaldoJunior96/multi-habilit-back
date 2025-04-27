<?php

use App\Models\Convenio;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\{get, post, put, delete};

uses(RefreshDatabase::class);

it('cria um convenio com sucesso', function () {
    $data = Convenio::factory()->make()->toArray();

    $convenio = Convenio::create($data);

    expect($convenio)->toBeInstanceOf(Convenio::class)
        ->and($convenio->id)->not->toBeNull();
});

it('lista convenios existentes', function () {
    $convenios = Convenio::factory()->count(3)->create();

    $this->assertCount(3, Convenio::all());
});

it('atualiza um convenio com sucesso', function () {
    $convenio = Convenio::factory()->create([
        'descricao' => 'Convenio Antigo',
    ]);

    $convenio->update([
        'descricao' => 'Convenio Atualizado',
    ]);

    $this->assertEquals('Convenio Atualizado', $convenio->fresh()->descricao);
});

it('deleta um convenio com sucesso', function () {
    $convenio = Convenio::factory()->create();

    $convenio->delete();

    $this->assertSoftDeleted('convenios', [
        'id' => $convenio->id,
    ]);
});
