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
        Schema::table('users', function (Blueprint $table) {
            $table->string('surname');
            $table->string('father_name')->nullable();
            $table->date('birthday')->nullable();
            $table->date('bio')->nullable();
            $table->timestamp('last_online')->nullable();
            $table->timestamp('city')->nullable();
            $table->timestamp('country')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('surname');
            $table->dropColumn('father_name');
            $table->dropColumn('birthday');
            $table->dropColumn('bio');
            $table->dropColumn('last_online');
            $table->dropColumn('city');
            $table->dropColumn('country');
        });
    }
};
