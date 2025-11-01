<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Cambiar el enum de rol para incluir 'user' en lugar de 'secretaria'
        Schema::table('users', function (Blueprint $table) {
            // Primero cambiar los valores existentes
            DB::statement("UPDATE users SET rol = 'user' WHERE rol = 'secretaria'");
            // Luego cambiar el enum
            $table->enum('rol', ['user', 'admin'])->default('user')->change();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Revertir el enum
            DB::statement("UPDATE users SET rol = 'secretaria' WHERE rol = 'user'");
            $table->enum('rol', ['admin', 'secretaria'])->default('secretaria')->change();
        });
    }
};
