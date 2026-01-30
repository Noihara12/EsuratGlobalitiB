<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TandaTangan extends Model
{
    protected $table = 'tanda_tangan';

    protected $fillable = [
        'user_id',
        'file_path',
        'original_filename',
        'file_type',
        'file_size',
        'description',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
