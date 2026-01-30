<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // For surat_masuk: add 'diarsip' to enum
        DB::statement("ALTER TABLE surat_masuk MODIFY COLUMN status ENUM('draft', 'submitted', 'disposed', 'received', 'diarsip') DEFAULT 'draft'");
        
        // For surat_keluar: add 'diarsip' to enum
        DB::statement("ALTER TABLE surat_keluar MODIFY COLUMN status ENUM('draft', 'published', 'diarsip') DEFAULT 'draft'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert surat_masuk enum
        DB::statement("ALTER TABLE surat_masuk MODIFY COLUMN status ENUM('draft', 'submitted', 'disposed', 'received') DEFAULT 'draft'");
        
        // Revert surat_keluar enum
        DB::statement("ALTER TABLE surat_keluar MODIFY COLUMN status ENUM('draft', 'published') DEFAULT 'draft'");
    }
};
