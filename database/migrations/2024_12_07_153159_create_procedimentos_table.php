<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProcedimentosTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('procedimentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_convenio')->constrained('convenios')->onDelete('cascade');
            $table->string('tabela')->nullable(); // Tabela
            $table->string('codigo')->nullable(); // Código
            $table->string('procedimento')->nullable(); // Procedimento
            $table->string('procedimento_padrao')->nullable(); // Procedimento Padrão
            $table->string('grupo')->nullable(); // Grupo
            $table->string('vacina')->nullable(); // Vacina
            $table->decimal('valor_ch', 10, 2)->nullable(); // Valor/CH
            $table->decimal('filme', 10, 2)->nullable(); // Filme (m²)
            $table->integer('porte_anestesia')->nullable(); // Porte Anestesia
            $table->decimal('ch_anestesista', 10, 2)->nullable(); // CH Anestesista
            $table->decimal('custo_operacional', 10, 2)->nullable(); // Custo Operacional
            $table->integer('numero_auxiliares')->nullable(); // Nº Auxiliares
            $table->string('codigo_tuss')->nullable(); // Código TUSS
            $table->string('instrumentador')->nullable(); // Instrumentador
            $table->integer('porte_honorario')->nullable(); // Porte Honorário
            $table->string('tempo')->nullable(); // Tempo
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('procedimentos');
    }
}
