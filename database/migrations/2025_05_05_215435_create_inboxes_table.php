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
        Schema::create('inboxes', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('title')->nullable();
            $table->mediumText('message')->nullable();
            $table->integer('user_id')->nullable();
            $table->dateTime('due_date')->nullable();
            $table->timestamp('send_at')->useCurrent();
            $table->timestamp('queue_at')->nullable();
            $table->string('status')->nullable();
            $table->string('team')->nullable();
            $table->json('like')->nullable();
            $table->string('type')->nullable();
            $table->string('action')->nullable();
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inboxes');
    }
};
