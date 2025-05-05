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
        Schema::create('order_h', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('order_no');
            $table->string('order_date', 512);
            $table->integer('customer_id');
            $table->string('customer_no', 128);
            $table->string('customer_name', 128);
            $table->string('customer_tel', 64);
            $table->text('customer_address');
            $table->integer('ship_id');
            $table->string('ship_contact', 256);
            $table->string('ship_name', 128);
            $table->string('ship_tel', 64);
            $table->text('ship_address');
            $table->timestamp('ship_date')->useCurrentOnUpdate()->useCurrent();
            $table->decimal('amount', 10, 0);
            $table->string('order_from', 512);
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
        Schema::dropIfExists('order_h');
    }
};
