<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Riwayat extends Model
{
    protected $fillable = ['judul', 'level', 'occurred_at'];

    protected $casts = ['occurred_at' => 'datetime'];

    /** Contoh: "20 Agustus 2026, 21:34" */
    public function getWaktuAttribute(): string
    {
        return $this->occurred_at->locale('id')->translatedFormat('j F Y, H:i');
    }
}
