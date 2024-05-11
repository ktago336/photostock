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
        Schema::table('communities', function (Blueprint $table) {
            $table->string('name');
            $table->string('bio')->nullable();
            $table->foreignId('user_id');
        });
        foreach (\App\Models\Post::whereNull('postable_type')->whereNotNull('author_id')->get() as $post){
            $post->postable_type = \App\Models\User::class;
            $post->postable_id = $post->author_id;
            $post->save();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('communities', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->dropColumn('bio');
            $table->dropColumn('user_id');
        });
    }
};
