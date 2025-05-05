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
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('picture')->nullable();
            $table->unsignedInteger('organization_id')->nullable();
            $table->string('team')->nullable();
            $table->string('email');
            $table->string('phone_number')->nullable();
            $table->bigInteger('user_id');
            $table->string('uid', 128)->nullable();
            $table->timestamps();

            $table->index(['organization_id', 'user_id'], 'organization_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_profiles');
    }
};
