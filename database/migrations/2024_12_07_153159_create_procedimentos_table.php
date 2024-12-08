<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('procedimentos', function (Blueprint $table) {
            $table->id(); // ID do procedimento
            $table->string('codigo')->nullable(); // Código do procedimento
            $table->string('nome')->nullable(); // Nome ou descrição do procedimento
            $table->decimal('valor_ch', 10, 2)->nullable(); // Valor/CH do procedimento
            $table->integer('porte_anestesia')->nullable(); // Porte anestésico
            $table->integer('ch_anestesista')->nullable(); // CH do anestesista
            $table->decimal('custo_operacional', 10, 2)->nullable(); // Custo operacional
            $table->integer('num_auxiliares')->nullable(); // Número de auxiliares
            $table->integer('tempo')->nullable(); // Tempo estimado (minutos)
            $table->decimal('valor_filme', 10, 2)->default(0); // Valor do filme
            $table->timestamps(); // Campos de criação e atualização
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('procedimentos');
    }
};
