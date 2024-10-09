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
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('nome_completo', 255);
            $table->string('email', 255)->unique();
            $table->string('password', 255);
            $table->date('data_nascimento');
            $table->string('sexo', 10);
            $table->string('rg', 20);
            $table->string('cpf', 11);
            $table->string('nome_social', 255)->nullable();
            $table->string('telefone', 20)->nullable();
            $table->string('celular', 20)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
