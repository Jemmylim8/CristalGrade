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
        Schema::create('classes', function (Blueprint $table) {
        $table->id();
        $table->string('name'); // Class name (e.g., BSIT 2A)
        $table->string('subject'); // Subject name
        $table->string('section'); // Section (A, B, etc.)
        $table->foreignId('faculty_id')->constrained('users')->onDelete('cascade'); 
        $table->string('join_code', 6)->unique(); // 6-character join code
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('class_models');
    }
};
