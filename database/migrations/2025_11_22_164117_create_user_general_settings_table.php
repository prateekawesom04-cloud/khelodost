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
            $table->string('admin_username')->nullable();
            $table->string('min_stake');
            $table->string('max_stake');
            $table->string('min_odds');
            $table->string('max_odds');
            $table->string('bet_delay');
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
