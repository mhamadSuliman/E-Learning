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
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // اسم الدرس
            $table->text('description')->nullable(); // وصف
            $table->string('video_url')->nullable(); // رابط الفيديو (محلي أو خارجي)
            $table->string('file_url')->nullable();  // رابط ملفات إضافية (PDF أو صور)
            $table->integer('order')->default(0);    // ترتيب الدرس ضمن الكورس
             // ربط كل درس بكورس
            $table->foreignId('course_id')
                  ->constrained('courses')
                  ->onDelete('cascade'); // إذا انحذف الكورس، تنحذف دروسه
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lesson');
    }
};
