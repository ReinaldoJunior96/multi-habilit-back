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
            $table->foreign('id_atendente')->references('id')->on('usuarios')->onDelete('cascade');
            $table->foreign('id_paciente')->references('id')->on('pacientes')->onDelete('cascade');
            $table->foreign('id_medico')->references('id')->on('medicos')->onDelete('cascade');
            $table->foreign('id_medico_substituto')->references('id')->on('medicos')->onDelete('cascade');
            $table->foreign('id_convenio')->references('id')->on('convenios')->onDelete('cascade');
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
            $table->dropForeign(['medico_id']);
            $table->dropForeign(['medico_substituto']);
            $table->dropForeign(['convenio']);
            $table->dropForeign(['procedimento']);
        });
    }
}
