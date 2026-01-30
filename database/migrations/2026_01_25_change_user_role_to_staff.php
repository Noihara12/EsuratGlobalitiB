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
        // Update semua user dengan role 'user' menjadi 'staff'
        DB::table('users')->where('role', 'user')->update(['role' => 'staff']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Rollback: ubah kembali 'staff' menjadi 'user'
        DB::table('users')->where('role', 'staff')->update(['role' => 'user']);
    }
};
