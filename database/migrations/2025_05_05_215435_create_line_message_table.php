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
        Schema::create('line_message', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('line_type', 16);
            $table->string('line_msg_type', 16);
            $table->string('line_user_type', 16);
            $table->string('line_user_id', 128);
            $table->text('line_msg_content')->nullable();
            $table->timestamp('created_at')->useCurrentOnUpdate()->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('line_message');
    }
};
