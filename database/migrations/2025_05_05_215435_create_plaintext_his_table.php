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
        Schema::create('plaintext_his', function (Blueprint $table) {
            $table->string('plan_id', 32)->primary();
            $table->string('plan_title', 512);
            $table->text('plan_context');
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrent();
            $table->dateTime('arch_at')->useCurrent();
            $table->integer('plan_status')->default(0);
            $table->dateTime('send_at')->useCurrent();
            $table->integer('plain_channel');
            $table->text('comment');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plaintext_his');
    }
};
