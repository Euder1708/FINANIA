<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('finanza_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('account_id')->constrained('finanza_accounts')->cascadeOnDelete();
            $table->foreignId('category_id')->nullable()->constrained('finanza_categories')->nullOnDelete();
            $table->decimal('amount', 20, 2);
            $table->string('type')->default('debit'); // debit|credit
            $table->text('description')->nullable();
            $table->timestamp('occurred_at')->useCurrent();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('finanza_transactions');
    }
};
