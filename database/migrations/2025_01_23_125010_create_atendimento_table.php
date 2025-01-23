<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('atendimentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agendamento_id')->constrained('agendamentos');
            //$table->string('title'); // Título do post
            $table->longText('conteudo');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('atendimentos');
    }
};
