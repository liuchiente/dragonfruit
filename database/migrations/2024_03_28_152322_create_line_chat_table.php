<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('line_chat', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('line_group_id', 64);
            $table->string('line_user_id', 64);
            $table->integer('type');
            $table->timestamp('join_at');
            $table->timestamp('leave_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('line_chat');
    }
};
