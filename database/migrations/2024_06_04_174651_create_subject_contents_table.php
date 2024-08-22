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
        Schema::create('subject_contents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('subject_id')->constrained('subjects')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('content_level_id')->constrained('content_levels')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('content_type_id')->constrained('content_types')->onDelete('cascade')->onUpdate('cascade');
            $table->string('name');
            $table->string('usage_level');
            $table->longText('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subject_contents');
    }
};
