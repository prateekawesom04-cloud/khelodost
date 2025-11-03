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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('admin_username')->nullable();
            $table->string('phone')->unique()->nullable();
            $table->string('country_phone_code')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('password')->nullable();
            $table->integer('status')->default(2);
            $table->string('referral')->nullable();
            $table->string('wallet_amount')->default(0);
            $table->string('win_amount')->default(0);
            $table->string('loss_amount')->default(0);
            $table->string('wager_amount')->default(0);
            $table->string('unsattled_amount')->default(0);
            $table->string('commission_amount')->default(0);
            $table->string('referral_code')->unique()->nullable();
            $table->integer('referral_nos')->default(0);
            $table->json('bonus')->nullable();
            $table->integer('last_login')->nullable();
            $table->json('additional_data')->nullable();
            $table->timestamps();
        });

        // Schema::create('password_reset_tokens', function (Blueprint $table) {
        //     $table->string('email')->primary();
        //     $table->string('token');
        //     $table->timestamp('created_at')->nullable();
        // });

        // Schema::create('sessions', function (Blueprint $table) {
        //     $table->string('id')->primary();
        //     $table->foreignId('user_id')->nullable()->index();
        //     $table->string('ip_address', 45)->nullable();
        //     $table->text('user_agent')->nullable();
        //     $table->longText('payload');
        //     $table->integer('last_activity')->index();
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
