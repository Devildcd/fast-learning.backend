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
        Schema::create('subject_error_images', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('error_id')->constrained('errors')->onDelete('cascade')->onUpdate('cascade');
            $table->string('urlImage');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subject_error_images');
    }
};
