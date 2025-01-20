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
            $table->timestamps();
        });
    }

    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('picture')->nullable();
            $table->foreignId('organization_id')->constrained()->onDelete('cascade'); // 假設有 'organizations' 表
            $table->string('team')->nullable();
            $table->text('fcm_token')->nullable();
            $table->text('auth_token')->nullable();
            $table->string('email')->unique();
            $table->string('phone_number')->nullable();
            $table->string('user_id')->unique();
            $table->string('sign_in_provider')->nullable();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
