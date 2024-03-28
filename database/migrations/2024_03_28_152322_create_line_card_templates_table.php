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
        Schema::create('line_card_templates', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('version')->default(1);
            $table->string('serial', 64);
            $table->integer('type');
            $table->integer('model');
            $table->string('publisher', 256);
            $table->string('subject', 512);
            $table->text('content');
            $table->text('sample');
            $table->text('link');
            $table->timestamp('publish_at')->nullable();
            $table->timestamp('expired_at')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('line_card_templates');
    }
};
