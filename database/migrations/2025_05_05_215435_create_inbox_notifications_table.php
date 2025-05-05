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
        Schema::create('inbox_notifications', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('inbox_id');
            $table->string('title')->nullable();
            $table->mediumText('message')->nullable();
            $table->integer('user_id')->nullable();
            $table->text('token')->nullable();
            $table->json('user_ids');
            $table->json('tokens');
            $table->timestamp('send_at')->nullable()->useCurrent();
            $table->dateTime('sent_at')->nullable();
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inbox_notifications');
    }
};
