<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgendamentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agendamentos', function (Blueprint $table) {
            $table->id(); // Primary key com auto-incremento
            $table->unsignedBigInteger('atendente');
            $table->unsignedBigInteger('paciente');
            $table->unsignedBigInteger('medico_id');
            $table->unsignedBigInteger('convenio');
            $table->unsignedBigInteger('procedimento');
            $table->dateTime('data_agendada');
            $table->tinyInteger('status')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agendamentos');
    }
}
