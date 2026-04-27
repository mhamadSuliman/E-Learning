<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('exercise_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exercise_id')->constrained('exercises')->onDelete('cascade');
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
            $table->text('answer'); // إجابة الطالب
            $table->boolean('is_correct')->nullable(); // نتيجة التصحيح
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exercise_answers');
    }
};

