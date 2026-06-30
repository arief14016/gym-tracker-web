<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('workout_plan_days', function (Blueprint $table) {
            $table->id();
            $table->foreignId('workout_plan_id')->constrained()->cascadeOnDelete();
            $table->integer('day_order');
            $table->string('name');
            $table->timestamps();

            $table->index(['workout_plan_id', 'day_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('workout_plan_days');
    }
};
