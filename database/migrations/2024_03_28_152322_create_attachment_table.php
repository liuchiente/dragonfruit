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
        Schema::create('attachment', function (Blueprint $table) {
            $table->integer('id');
            $table->string('name', 256);
            $table->string('name_o', 256);
            $table->string('description', 512);
            $table->integer('type');
            $table->string('mime', 32);
            $table->integer('hits');
            $table->text('link');
            $table->text('link_o');
            $table->string('id_o', 8);
            $table->string('publisher_o', 256);
            $table->timestamp('expired_at')->nullable();
            $table->timestamp('created_at');
            $table->timestamp('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attachment');
    }
};
