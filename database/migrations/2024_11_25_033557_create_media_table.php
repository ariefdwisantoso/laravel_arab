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
        Schema::create('media', function (Blueprint $table) {
            $table->id(); 
            $table->unsignedBigInteger('theme_id')->nullable();
            $table->string('name'); 
            $table->string('type');
            $table->string('file_path');
            $table->text('description')->nullable();
            $table->boolean('status')->default(true);  
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('theme_id')->references('id')->on('theme')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};