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
    Schema::table('score_histories', function (Blueprint $table) {
        $table->foreignId('activity_id')->nullable()->after('student_id')
              ->constrained('activities')
              ->onDelete('set null');
    });
}

public function down(): void
{
    Schema::table('score_histories', function (Blueprint $table) {
        $table->dropColumn('activity_id');
    });
}

};
