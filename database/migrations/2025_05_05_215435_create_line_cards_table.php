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
        Schema::create('line_cards', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('template_id');
            $table->integer('user_id');
            $table->integer('group_id');
            $table->string('subject', 512);
            $table->text('content');
            $table->text('template')->nullable();
            $table->string('variable', 256)->nullable();
            $table->integer('msg_type')->comment('訊息類型');
            $table->integer('shared');
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('line_cards');
    }
};
