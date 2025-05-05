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
        Schema::create('line_message_logs', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('webhook_event_id');
            $table->string('type', 50);
            $table->string('timestamp', 32);
            $table->string('source_type', 50);
            $table->string('group_id')->nullable();
            $table->string('user_id')->nullable();
            $table->string('message_type', 50);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('line_message_logs');
    }
};
