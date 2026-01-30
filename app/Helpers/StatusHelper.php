<?php

namespace App\Helpers;

class StatusHelper
{
    /**
     * Translate status to Indonesian
     */
    public static function translateStatus($status)
    {
        $translations = [
            'draft' => 'Draft',
            'submitted' => 'Diajukan',
            'disposed' => 'Didisposisikan',
            'received' => 'Diterima',
            'pending' => 'Menunggu',
            'in_progress' => 'Dalam Proses',
            'completed' => 'Selesai',
            'published' => 'Dipublikasikan',
        ];

        return $translations[$status] ?? ucfirst(str_replace('_', ' ', $status));
    }
}
