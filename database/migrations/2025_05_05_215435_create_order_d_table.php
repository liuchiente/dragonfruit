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
        Schema::create('order_d', function (Blueprint $table) {
            $table->integer('id');
            $table->integer('inquiry_h_id');
            $table->integer('part_id');
            $table->string('part_no', 256);
            $table->string('part_name', 512);
            $table->decimal('part_count', 10, 0);
            $table->decimal('part_price', 10, 0);
            $table->decimal('sub_total', 10, 0);
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_d');
    }
};
