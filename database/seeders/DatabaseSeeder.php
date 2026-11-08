<?php

namespace Database\Seeders;

use App\Models\Riwayat;
use App\Models\SensorReading;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Data sensor awal (sesuai desain)
        SensorReading::create([
            'kemiringan' => 0, 'getaran' => 0, 'kelembapan_tanah' => 56,
            'suhu' => 28, 'kelembapan_udara' => 70,
        ]);

        // Riwayat contoh (sesuai desain; jam 07:65 di desain diganti 07:05 karena tidak valid)
        $data = [
            ['Getaran Terdeteksi',   'awas',    '2026-08-20 21:34:00'],
            ['Sistem Normal',        'normal',  '2026-11-06 09:21:00'],
            ['Kemiringan berubah',   'waspada', '2026-11-12 07:05:00'],
            ['Sistem Normal',        'normal',  '2026-07-02 09:56:00'],
            ['Sistem Normal',        'normal',  '2026-06-09 09:21:00'],
        ];
        foreach ($data as [$judul, $level, $waktu]) {
            Riwayat::create(['judul' => $judul, 'level' => $level, 'occurred_at' => $waktu]);
        }
    }
}
