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
        Schema::create('convenio_procedimentos', function (Blueprint $table) {
            $table->id(); // ID da relação
            $table->foreignId('convenio_id')->constrained('convenios')->onDelete('cascade'); // ID do convênio
            $table->foreignId('procedimento_id')->constrained('procedimentos')->onDelete('cascade'); // ID do procedimento
            $table->decimal('preco', 10, 2)->default(0); // Preço específico para o convênio
            $table->timestamps(); // Campos de criação e atualização
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('convenio_procedimentos');
    }
};
