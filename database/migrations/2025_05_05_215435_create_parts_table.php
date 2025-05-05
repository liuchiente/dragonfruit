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
        Schema::create('parts', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('part_no', 256);
            $table->string('part_name', 512);
            $table->string('short_name', 256);
            $table->string('brand', 256);
            $table->string('model', 256);
            $table->string('unit', 4);
            $table->decimal('part_price', 10, 0);
            $table->text('part_search');
            $table->integer('part_ord');
            $table->integer('is_on');
            $table->integer('hits');
            $table->text('link');
            $table->text('link_o');
            $table->text('thumb')->nullable();
            $table->string('id_o', 8);
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parts');
    }
};
