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
        Schema::table('comments', function (Blueprint $table) {
            $table->text('text');
            $table->foreignId('commentable_id');
            $table->foreignId('parent_comment_id')->nullable();
            $table->string('commentable_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->dropColumn('text');
            $table->dropColumn('commentable_id');
            $table->dropColumn('parent_comment_id');
            $table->dropColumn('commentable_type');
        });
    }
};
