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
        Schema::create('orcamento', function (Blueprint $table) {
            $table->id();
            $table->string('nome_paciente');
            $table->string('tipo_servico')->nullable();
            $table->integer('numero_sessoes')->nullable();
            $table->decimal('valor_unitario', 10, 2)->nullable();
            $table->decimal('desconto', 5, 2)->nullable(); // Desconto em porcentagem
            $table->text('observacoes')->nullable();
            $table->string('status')->nullable()->default('Pendente');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orcamento');
    }
};
