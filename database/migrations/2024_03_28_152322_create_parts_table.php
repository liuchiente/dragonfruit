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
        Schema::create('parts', function (Blueprint $table) {
            $table->integer('id');
            $table->string('part_no', 256);
            $table->string('part_name', 512);
            $table->string('short_name', 256);
            $table->string('brand', 256);
            $table->string('model', 256);
            $table->string('unit', 4);
            $table->text('part_search');
            $table->integer('part_ord');
            $table->integer('is_on');
            $table->integer('hits');
            $table->text('link');
            $table->text('link_o');
            $table->string('id_o', 8);
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
        Schema::dropIfExists('parts');
    }
};
