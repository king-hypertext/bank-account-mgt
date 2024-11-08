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
        Schema::create('transactions', function (Blueprint $table) {
            // $table->id();
            // $table->string('ref')->nullable();
            // $table->foreignId('from_account_id')->constrained();
            // $table->foreignId('to_account_id')->constrained();
            // $table->decimal('amount', 10, 2);
            // $table->foreignId('transaction_type_id')->constrained();
            // $table->text('description')->nullable();
            // $table->index(['account_id']);
            // $table->boolean('is_reconciled')->default(false);
            // $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
