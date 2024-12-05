<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToAgendamentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('agendamentos', function (Blueprint $table) {
            $table->foreign('atendente')->references('id')->on('usuarios')->onDelete('cascade');
            $table->foreign('paciente')->references('id')->on('pacientes')->onDelete('cascade');
            $table->foreign('medico')->references('id')->on('medicos')->onDelete('cascade');
            $table->foreign('convenio')->references('id')->on('convenios')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('agendamentos', function (Blueprint $table) {
            $table->dropForeign(['atendente']);
            $table->dropForeign(['paciente']);
            $table->dropForeign(['medico']);
            $table->dropForeign(['convenio']);
        });
    }
}
