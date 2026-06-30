<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('exercises', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('muscle_group', [
                'chest', 'back', 'shoulders', 'biceps', 'triceps',
                'forearms', 'core', 'quadriceps', 'hamstrings',
                'glutes', 'calves', 'full_body', 'cardio'
            ]);
            $table->text('description')->nullable();
            $table->string('video_url')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();

            $table->index('muscle_group');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exercises');
    }
};
