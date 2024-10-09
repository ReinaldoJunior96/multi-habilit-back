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
        Schema::create('convenios', function (Blueprint $table) {
            $table->id(); // ID primário auto-incrementado
            $table->string('empresa', 255);
            $table->string('tipo', 50);
            $table->date('vencimento')->nullable();
            $table->integer('percentual_coparticipacao')->default(0);
            $table->boolean('particular')->default(false);
            $table->foreignId('id_paciente')->constrained('pacientes')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('convenios');
    }
};
