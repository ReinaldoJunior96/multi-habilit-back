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
        Schema::create('enderecos', function (Blueprint $table) {
            $table->id();
            $table->string('cep', 20);
            $table->string('logradouro', 255);
            $table->string('complemento', 255)->nullable();
            $table->string('bairro', 100);
            $table->string('uf', 2);
            $table->foreignId('id_usuario')->constrained('usuarios')->unique()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enderecos');
    }
};
