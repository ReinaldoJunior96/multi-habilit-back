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
        Schema::create('pacientes', function (Blueprint $table) {
            $table->id();
            $table->string('estado_civil', 20);
            $table->string('nome_mae', 200);
            $table->string('nome_pai', 200)->nullable();
            $table->boolean('prefrencial')->default(false);
            $table->string('cns')->nullable(); // Cartão Nacional de Saúde
            $table->string('nome_conjuge')->nullable();
            $table->string('cor_raca')->nullable();
            $table->string('profissao')->nullable();
            $table->text('instrucao')->nullable();
            $table->string('nacionalidade')->nullable();
            $table->string('tipo_sanguineo')->nullable();
            $table->foreignId('id_usuario')->constrained('usuarios')->onDelete('cascade');
            //$table->foreignId('id_responsavel')->nullable()->constrained('usuarios')->onDelete('cascade'); // O responsável também é um usuário
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pacientes');
    }
};
