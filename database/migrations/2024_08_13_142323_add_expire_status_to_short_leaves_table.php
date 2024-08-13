<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExpireStatusToShortLeavesTable extends Migration
{
    public function up()
    {
        Schema::table('short_leaves', function (Blueprint $table) {
            $table->enum('status', ['pending', 'approved', 'rejected', 'expire'])->default('pending')->change();
        });
    }

    public function down()
    {
        Schema::table('short_leaves', function (Blueprint $table) {
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending')->change();
        });
    }
}

