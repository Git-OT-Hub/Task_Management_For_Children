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
            $table->id();
            $table->foreignId('room_id')->constrained('rooms')->cascadeOnDelete();
            $table->foreignId('task_sender')->constrained('users')->cascadeOnDelete();
            $table->foreignId('task_recipient')->constrained('users')->cascadeOnDelete();
            $table->string('title', 50);
            $table->timestamp('deadline');
            $table->integer('point');
            $table->text('body', 1000)->nullable();
            $table->string('image', 100)->nullable();
            $table->boolean('complete_flg')->default(false);
            $table->boolean('approval_flg')->default(false);
            $table->timestamps();
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
