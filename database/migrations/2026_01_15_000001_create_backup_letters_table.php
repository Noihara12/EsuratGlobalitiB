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
        Schema::create('backup_letters', function (Blueprint $table) {
            $table->id();
            $table->string('backup_name');
            $table->enum('type', ['surat_masuk', 'surat_keluar', 'all']);
            $table->integer('total_letters');
            $table->integer('total_attachments');
            $table->bigInteger('file_size')->default(0);
            $table->string('file_path');
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('backup_letters');
    }
};
