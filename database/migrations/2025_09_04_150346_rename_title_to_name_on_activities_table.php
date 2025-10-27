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
        Schema::table('activities', function (Blueprint $table) {
            $table->renameColumn('title', 'name');
        });
    }

    public function down()
    {
        Schema::table('activities', function (Blueprint $table) {
            $table->renameColumn('name', 'title');
        });
    }

};
