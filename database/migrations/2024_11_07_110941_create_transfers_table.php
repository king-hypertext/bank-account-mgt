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
        Schema::create('transfers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('from_account_id')->index('from_account_id');
            $table->unsignedBigInteger('to_account_id')->index('to_account_id');
            $table->unsignedBigInteger('transaction_type_id');
            $table->decimal('amount', 10, 2);
            $table->text('notes')->nullable();
            $table->foreign('from_account_id')->references('id')->on('accounts');
            $table->foreign('to_account_id')->references('id')->on('accounts');
            $table->foreign('transaction_type_id')->references('id')->on('transaction_types');
            $table->softDeletes();
            $table->timestamps();
            // $table->unsignedBigInteger('transaction_status_id');
            // $table->foreign('transaction_status_id')->references('id')->on('transaction_statuses');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfers');
    }
};