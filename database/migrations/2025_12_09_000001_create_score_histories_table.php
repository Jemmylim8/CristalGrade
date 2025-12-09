<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('score_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('faculty_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('class_id')->constrained('classes')->onDelete('cascade');
            $table->string('component'); // e.g. Quiz 1, Midterm
            $table->decimal('old_score', 8, 2)->nullable();
            $table->decimal('new_score', 8, 2)->nullable();
            $table->json('meta')->nullable(); // optional extra info (ip, reason, user_agent)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('score_histories');
    }
};
