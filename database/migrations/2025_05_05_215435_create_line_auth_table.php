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
        Schema::create('line_auth', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('line_user_id', 64);
            $table->string('line_display_name', 128);
            $table->string('line_status_msg', 256)->nullable();
            $table->string('line_pic_url', 512)->nullable();
            $table->bigInteger('user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('line_auth');
    }
};
