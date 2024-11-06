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
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('account_location_id')->constrained();
            $table->string('ref');
            $table->string('name');
            $table->string('bank_name');
            $table->string('account_name');
            $table->foreignId('account_type_id')->constrained();
            $table->foreignId('account_status_id')->constrained();
            $table->string('account_address')->nullable();
            $table->decimal('initial_amount', 15, 2)->default(0)->nullable();
            $table->text('account_description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};
