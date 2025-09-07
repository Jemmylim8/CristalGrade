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
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_id')->constrained('classes')->onDelete('cascade');
            $table->string('title'); // Example: Quiz 1, Exam 2
            $table->string('type')->default('activity'); // quiz, exam, project, etc.
            $table->text('description')->nullable();
            $table->integer('max_score')->default(100);
            $table->date('due_date')->nullable(); // ✅ NEW
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
