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
        Schema::create('tanda_tangan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('file_path')->nullable(); // Path to the signature file (jpg, png, pdf)
            $table->string('original_filename');
            $table->string('file_type'); // jpg, png, pdf
            $table->integer('file_size'); // Size in bytes
            $table->text('description')->nullable(); // Optional description
            $table->timestamps();
            
            // Ensure only one signature per user
            $table->unique('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tanda_tangan');
    }
};
