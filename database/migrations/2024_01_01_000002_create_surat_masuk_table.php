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
        Schema::create('surat_masuk', function (Blueprint $table) {
            $table->id();
            $table->enum('jenis_surat', ['rahasia', 'penting', 'biasa'])->default('biasa');
            $table->string('kode_surat');
            $table->string('nomor_surat')->unique();
            $table->date('tanggal_surat');
            $table->string('asal_surat');
            $table->text('perihal');
            $table->text('catatan')->nullable();
            $table->string('file_lampiran')->nullable();
            $table->enum('status', ['draft', 'submitted', 'disposed', 'received'])->default('draft');
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->foreignId('kepala_sekolah_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_masuk');
    }
};
