<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Disposisi extends Model
{
    protected $table = 'disposisi';
    
    protected $fillable = [
        'surat_masuk_id',
        'disposisi_ke',
        'isi_disposisi',
        'catatan_kepala_sekolah',
        'tanda_tangan_file',
        'status',
        'received_at',
        'created_by'
    ];

    protected $casts = [
        'received_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function suratMasuk(): BelongsTo
    {
        return $this->belongsTo(SuratMasuk::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'disposisi_ke');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
