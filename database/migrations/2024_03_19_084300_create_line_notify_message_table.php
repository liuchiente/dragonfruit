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
        Schema::create('line_notify_message', function (Blueprint $table) {
            $table->string('msg_id', 32)->primary();
            $table->string('msg_title', 512);
            $table->text('msg_context');
            $table->char('plan_id', 32);
            $table->char('chl_id', 64);
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrent();
            $table->dateTime('send_at')->nullable()->useCurrent();
            $table->dateTime('sent_at')->nullable()->useCurrent();
            $table->integer('chl_type')->default(0);
            $table->integer('msg_status')->default(0);
            $table->text('comment');

            $table->index(['plan_id', 'chl_id'], 'plan_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('line_notify_message');
    }
};
