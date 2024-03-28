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
        Schema::create('line_member', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('line_user_id', 64);
            $table->string('line_display_name', 128);
            $table->string('line_status_msg', 256)->nullable();
            $table->string('line_pic_url', 512)->nullable();
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
        Schema::dropIfExists('line_member');
    }
};
