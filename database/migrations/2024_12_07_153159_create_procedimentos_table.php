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
            $table->decimal('valor_ch', 10, 2)->nullable();
            $table->integer('porte_anestesia')->nullable();
            $table->integer('ch_anestesista')->nullable();
            $table->decimal('custo_operacional', 10, 2)->nullable();
            $table->string('codigo_tuss')->nullable();
            $table->integer('num_auxiliares')->nullable();
            $table->integer('tempo')->nullable();
            $table->decimal('valor_filme', 10, 2)->default(0);
            $table->foreignId('convenio_id')->constrained('convenios')->onDelete('cascade'); // Relação com convênios
            $table->softDeletes();
            $table->timestamps();
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
