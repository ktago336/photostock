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
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('image');
            $table->boolean('active')->default(1);
            $table->boolean('is_avatar')->default(0);

            $table->foreignId('imageable_id')->nullable();
            $table->string('imageable_type')->nullable();

            $table->foreignId('author_id')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('images');
    }
};
