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
        Schema::create('line_notify_plaintext', function (Blueprint $table) {
            $table->integer('id', true);
            $table->char('plan_id', 32);
            $table->string('plan_title', 512);
            $table->text('plan_context');
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrent();
            $table->dateTime('send_at')->useCurrent();
            $table->integer('plain_channel')->default(-1);
            $table->integer('plain_schedule')->default(-1);
            $table->integer('plan_status')->default(2);
            $table->integer('plain_type')->default(1);
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
        Schema::dropIfExists('line_notify_plaintext');
    }
};
