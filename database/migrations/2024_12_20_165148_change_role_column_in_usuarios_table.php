<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('usuarios', function (Blueprint $table) {
            $table->string('role')->change(); // Altera o tipo de `enum` para `string`
        });
    }

    public function down(): void
    {
        Schema::table('usuarios', function (Blueprint $table) {
            $table->enum('role', ['admin-master', 'admin', 'atendente', 'medico', 'paciente'])->change(); // Reverte para `enum`
        });
    }
};
