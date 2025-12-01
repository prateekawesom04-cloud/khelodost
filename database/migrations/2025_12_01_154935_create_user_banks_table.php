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
        Schema::create('user_banks', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->string('account_holder');
            $table->string('bank_name')->nullable();
            $table->string('ifsc_code',11)->nullable();
            $table->string('account_id')->nullable();
            // $table->string('account_number',18)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_banks');
    }
};
