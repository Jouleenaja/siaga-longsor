<?php

return [
    /*
     | Ambang batas status. Nilai >= 'waspada' => Waspada, nilai >= 'awas' => Awas.
     | Sesuaikan dengan kalibrasi sensor Anda.
     */
    'threshold' => [
        'kemiringan'       => ['waspada' => 5,    'awas' => 15],   // derajat
        'getaran'          => ['waspada' => 0.1,  'awas' => 0.3],  // g
        'kelembapan_tanah' => ['waspada' => 75,   'awas' => 90],   // persen
    ],

    // Kosongkan untuk menonaktifkan. Alat harus kirim header: X-API-KEY
    'api_key' => env('SIAGA_API_KEY'),
];
