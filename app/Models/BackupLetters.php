<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BackupLetters extends Model
{
    protected $table = 'backup_letters';

    protected $fillable = [
        'backup_name',
        'type',
        'total_letters',
        'total_attachments',
        'file_size',
        'file_path',
        'created_by',
        'notes',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get human readable file size
     */
    public function getFormattedSizeAttribute(): string
    {
        $bytes = $this->file_size;
        $sizes = ['B', 'KB', 'MB', 'GB'];
        
        if ($bytes === 0) return '0 B';
        
        $i = (int)floor(log($bytes, 1024));
        
        if ($i === 0) return $bytes . ' ' . $sizes[$i];
        
        return round($bytes / pow(1024, $i), 2) . ' ' . $sizes[$i];
    }
}
