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
        Schema::create('user_general_settings', function (Blueprint $table) {
            $table->id();
            $table->string('min_stake');
            $table->string('max_stake');
            $table->string('max_profit');
            $table->string('max_loss');
            $table->string('betdelay');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_general_settings');
    }
};
