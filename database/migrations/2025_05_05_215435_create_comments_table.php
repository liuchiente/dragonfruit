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
        Schema::create('comments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->mediumText('message');
            $table->unsignedBigInteger('user_id')->index('user_id');
            $table->longText('like')->nullable()->default('[]');
            $table->string('type');
            $table->string('action');
            $table->json('attaches');
            $table->unsignedBigInteger('inbox_id')->index('inbox_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
