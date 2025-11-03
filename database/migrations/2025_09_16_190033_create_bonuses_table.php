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
        Schema::create('bonuses', function (Blueprint $table) {
            $table->id();
            $table->string('bonus_uid')->nullable();
            $table->string('name')->nullable();
            $table->tinyInteger('type')->nullable();
            $table->decimal('amount',10,2)->nullable();
            $table->decimal('wager_amount',10,2)->nullable();
            $table->text('description')->nullable();
            $table->string('expiry_time')->nullable();
            $table->boolean('status')->nullable();
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bonuses');
    }
};
