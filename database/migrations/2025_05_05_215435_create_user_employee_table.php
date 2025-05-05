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
        Schema::create('user_employee', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('emp_account')->unique('emp_account');
            $table->integer('emp_id');
            $table->string('emp_no', 8)->default('');
            $table->string('emp_password', 128);
            $table->bigInteger('user_profile_id');
            $table->string('emp_name');
            $table->string('email');
            $table->char('identity', 1);
            $table->integer('IDRep');
            $table->decimal('leave_day', 5, 4)->nullable()->default(0);
            $table->dateTime('login_time');
            $table->string('login_key', 128);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_employee');
    }
};
