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
        Schema::create('line_chat', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('line_group_id', 64);
            $table->string('line_user_id', 64);
            $table->integer('type');
            $table->timestamp('join_at')->nullable();
            $table->timestamp('leave_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('line_chat');
    }
};
