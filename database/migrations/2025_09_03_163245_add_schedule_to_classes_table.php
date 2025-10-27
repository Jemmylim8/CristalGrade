<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('classes', function (Blueprint $table) {
        $table->string('schedule')->nullable()->after('section');
    });
}

public function down()
{
    Schema::table('classes', function (Blueprint $table) {
        $table->dropColumn('schedule');
    });
}
};
