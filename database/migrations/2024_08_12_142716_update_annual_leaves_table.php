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
        Schema::table('annual_leaves', function (Blueprint $table) {
            $table->unsignedInteger('total_leaves')->default(0)->change();
            $table->unsignedInteger('used_leaves')->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('annual_leaves', function (Blueprint $table) {
            $table->integer('total_leaves')->default(0)->change();
            $table->integer('used_leaves')->default(0)->change();
        });
    }
};
