<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SensorReading extends Model
{
    protected $fillable = [
        'kemiringan', 'getaran', 'kelembapan_tanah', 'suhu', 'kelembapan_udara',
    ];

    protected $casts = [
        'kemiringan'       => 'float',
        'getaran'          => 'float',
        'kelembapan_tanah' => 'float',
        'suhu'             => 'float',
        'kelembapan_udara' => 'float',
    ];

    /** Data terbaru, atau data kosong (semua 0) bila belum ada. */
    public static function latestOrDefault(): self
    {
        return static::latest('id')->first() ?? new static([
            'kemiringan' => 0, 'getaran' => 0, 'kelembapan_tanah' => 0,
            'suhu' => 0, 'kelembapan_udara' => 0,
        ]);
    }
}
