<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('finanza_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type')->nullable(); // cash, bank, credit
            $table->string('currency', 8)->default('USD');
            $table->decimal('balance', 20, 2)->default(0);
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('finanza_accounts');
    }
};
