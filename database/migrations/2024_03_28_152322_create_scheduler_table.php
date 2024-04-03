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
        Schema::create('scheduler', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('scheduler_id', 16);
            $table->string('scheduler_cron', 16);
            $table->timestamp('created_at');
            $table->timestamp('updated_at');
            $table->timestamp('next_at');
            $table->string('target', 128);
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
        Schema::dropIfExists('scheduler');
    }
};
