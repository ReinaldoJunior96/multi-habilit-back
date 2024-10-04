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
        Schema::create('medicos', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('regime_trabalhista');
            $table->integer('carga_horaria');
            $table->string('cnpj', 14);  // CNPJ único para garantir que cada médico tenha um CNPJ exclusivo
            $table->foreignId('id_usuario')->constrained('usuarios')->onDelete('cascade')->unique(); // Garante que id_usuario seja único
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicos');
    }
};
