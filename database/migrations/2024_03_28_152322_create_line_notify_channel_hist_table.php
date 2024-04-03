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
        Schema::create('line_notify_channel_hist', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->bigInteger('chl_id');
            $table->integer('user_id');
            $table->string('chl_tag', 128);
            $table->integer('chl_status')->default(0);
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrent();
            $table->dateTime('arch_at')->useCurrent();
            $table->integer('msg_status')->default(0);
            $table->text('comment')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('line_notify_channel_hist');
    }
};
