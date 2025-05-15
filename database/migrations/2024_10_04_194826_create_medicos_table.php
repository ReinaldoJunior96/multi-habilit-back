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
            $table->string('nome_completo');
            $table->string('email')->unique();
            $table->date('data_nascimento')->nullable();
            $table->string('sexo')->nullable();
            $table->string('cpf')->unique();
            $table->string('telefone')->nullable();
            $table->string('tipo')->nullable();
            $table->tinyInteger('regime_trabalhista'); // tinyInteger para uso com enum PHP
            $table->integer('carga_horaria')->nullable();
            $table->string('cnpj')->nullable();
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
