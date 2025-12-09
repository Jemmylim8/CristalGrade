<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('attendance_records', function (Blueprint $table) {
            $table->string('excuse_file')->nullable()->after('status');
            $table->enum('excuse_status', ['Pending','Approved','Rejected'])->default('Pending')->after('excuse_file');
            $table->text('excuse_remark')->nullable()->after('excuse_status');
        });
    }

    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropColumn(['excuse_file','excuse_status','excuse_remark']);
        });
    }
};
