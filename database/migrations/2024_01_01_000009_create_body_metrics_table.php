<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('body_metrics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('recorded_by')->constrained('users')->cascadeOnDelete();
            $table->date('date');
            $table->decimal('weight', 6, 2)->comment('Weight in kg');
            $table->decimal('height', 6, 2)->nullable()->comment('Height in cm');
            $table->decimal('body_fat_percentage', 5, 2)->nullable();
            $table->string('progress_photo')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('body_metrics');
    }
};
