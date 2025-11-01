<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('finanza_budgets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('finanza_categories')->cascadeOnDelete();
            $table->decimal('amount', 20, 2);
            $table->date('start_date');
            $table->date('end_date');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('finanza_budgets');
    }
};
