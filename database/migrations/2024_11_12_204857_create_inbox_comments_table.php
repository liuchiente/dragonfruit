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
        Schema::create('inbox_comments', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });
    }

    public function up()
    {
        Schema::create('inbox_comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inbox_id')->constrained()->onDelete('cascade'); // 假設有 'inboxes' 表
            $table->foreignId('comment_id')->constrained()->onDelete('cascade'); // 假設有 'comments' 表
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inbox_comments');
    }
};
