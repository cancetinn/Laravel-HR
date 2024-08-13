<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReasonToShortLeavesTable extends Migration
{
    public function up()
    {
        Schema::table('short_leaves', function (Blueprint $table) {
            $table->string('reason')->nullable();
        });
    }

    public function down()
    {
        Schema::table('short_leaves', function (Blueprint $table) {
            $table->dropColumn('reason');
        });
    }
}

