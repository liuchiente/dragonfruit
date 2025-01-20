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
            $table->id();
            $table->timestamps();
        });
    }

    public function up()
    {
        Schema::create('inboxes', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('message');
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // 假設有 User 表
            $table->dateTime('due_date')->nullable();
            $table->string('status');
            $table->string('team');
            $table->json('like')->nullable(); // 假設 'like' 儲存為 JSON 格式
            $table->string('type');
            $table->string('action');
            $table->timestamps();
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
