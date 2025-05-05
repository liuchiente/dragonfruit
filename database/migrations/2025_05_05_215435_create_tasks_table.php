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
        Schema::create('tasks', function (Blueprint $table) {
            $table->integer('id', true);
            $table->text('description')->nullable();
            $table->timestamp('due_date')->nullable();
            $table->boolean('is_reminder')->nullable();
            $table->longText('assignees')->nullable();
            $table->integer('organization_id');
            $table->integer('created_by')->nullable();
            $table->string('team')->nullable();
            $table->string('status')->nullable();
            $table->string('priority_level')->nullable();
            $table->dateTime('created_at');
            $table->dateTime('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
