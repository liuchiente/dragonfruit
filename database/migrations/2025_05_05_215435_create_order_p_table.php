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
        Schema::create('order_p', function (Blueprint $table) {
            $table->integer('id');
            $table->integer('order_h_id');
            $table->integer('part_id');
            $table->string('payment_no', 64);
            $table->string('payment_name', 512);
            $table->decimal('payment_amt', 10, 0);
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_p');
    }
};
