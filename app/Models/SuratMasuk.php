<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SuratMasuk extends Model
{
    protected $table = 'surat_masuk';
    
    protected $fillable = [
        'jenis_surat',
        'kode_surat',
        'nomor_surat',
        'tanggal_surat',
        'asal_surat',
        'perihal',
        'catatan',
        'file_lampiran',
        'status',
        'created_by',
        'kepala_sekolah_id',
        'is_archived',
        'archived_at'
    ];

    protected $casts = [
        'tanggal_surat' => 'date',
        'archived_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function kepalaSekolah(): BelongsTo
    {
        return $this->belongsTo(User::class, 'kepala_sekolah_id');
    }

    public function disposisi(): HasMany
    {
        return $this->hasMany(Disposisi::class, 'surat_masuk_id', 'id');
    }
}
