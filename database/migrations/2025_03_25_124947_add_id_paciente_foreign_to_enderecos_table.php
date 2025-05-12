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
        Schema::table('enderecos', function (Blueprint $table) {

            $table->foreignId('id_paciente')->nullable()->constrained('pacientes')->unique()->onDelete('cascade');

            $table->foreignId('id_convenio')->nullable()->constrained('convenios')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('enderecos', function (Blueprint $table) {
            $table->dropForeign(['id_paciente']);
            $table->dropColumn('id_paciente');

            $table->dropForeign(['id_convenio']);
            $table->dropColumn('id_convenio');
        });
    }
};
