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
        Schema::create('disposisi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('surat_masuk_id')->constrained('surat_masuk')->onDelete('cascade');
            $table->foreignId('disposisi_ke')->constrained('users')->onDelete('cascade');
            $table->text('isi_disposisi');
            $table->text('catatan_kepala_sekolah')->nullable();
            $table->string('tanda_tangan_file')->nullable();
            $table->enum('status', ['pending', 'received', 'in_progress', 'completed'])->default('pending');
            $table->timestamp('received_at')->nullable();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disposisi');
    }
};
