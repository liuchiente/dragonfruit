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
        Schema::create('news', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('publisher_from', 512);
            $table->string('publisher', 256);
            $table->string('subject', 512);
            $table->text('content');
            $table->text('content_rich');
            $table->text('link');
            $table->text('link_o');
            $table->string('id_o', 8);
            $table->string('publisher_o', 256);
            $table->timestamp('publish_at')->nullable();
            $table->timestamp('expired_at')->nullable();
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
