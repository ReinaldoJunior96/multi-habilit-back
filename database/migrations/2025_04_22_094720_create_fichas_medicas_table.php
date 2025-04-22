<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFichasMedicasTable extends Migration
{
    public function up()
    {
        Schema::create('fichas_medicas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paciente_id')->constrained('pacientes')->onDelete('cascade');
            $table->json('ficha');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('fichas_medicas');
    }
}
