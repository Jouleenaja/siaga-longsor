<?php

namespace App\Services;

use App\Models\SensorReading;

/**
 * Menentukan status lereng dari data sensor.
 * Ubah angka ambang batas di config/siaga.php sesuai kondisi di lapangan.
 */
class SlopeStatus
{
    public const RANK = ['normal' => 0, 'waspada' => 1, 'awas' => 2];

    public static function evaluate(SensorReading $r): array
    {
        $t = config('siaga.threshold');

        $kemiringan = self::grade($r->kemiringan, $t['kemiringan']);
        $getaran    = self::grade($r->getaran, $t['getaran']);
        $tanah      = self::grade($r->kelembapan_tanah, $t['kelembapan_tanah']);

        $sensors = [
            'kemiringan' => [
                'level' => $kemiringan,
                'value' => self::trim(self::num($r->kemiringan, 1)) . '°',
                'text'  => ['normal' => 'Stabil', 'waspada' => 'Berubah', 'awas' => 'Berbahaya'][$kemiringan],
                'badge' => ['normal' => 'Stabil', 'waspada' => 'Waspada', 'awas' => 'Awas'][$kemiringan],
            ],
            'getaran' => [
                'level' => $getaran,
                'value' => self::num($r->getaran, 1) . ' g',
                'text'  => ['normal' => 'Tidak terdeteksi', 'waspada' => 'Getaran lemah', 'awas' => 'Terdeteksi'][$getaran],
                'badge' => ['normal' => 'Normal', 'waspada' => 'Waspada', 'awas' => 'Awas'][$getaran],
            ],
            'kelembapan_tanah' => [
                'level' => $tanah,
                'value' => self::num($r->kelembapan_tanah, 0) . '%',
                'text'  => ['normal' => 'Normal', 'waspada' => 'Basah', 'awas' => 'Jenuh'][$tanah],
                'badge' => ['normal' => 'Normal', 'waspada' => 'Waspada', 'awas' => 'Awas'][$tanah],
            ],
            'suhu' => [
                'level' => 'normal',
                'value' => self::num($r->suhu, 0) . '°C',
                'text'  => 'DHT11',
                'badge' => 'Normal',
            ],
            'kelembapan_udara' => [
                'level' => 'normal',
                'value' => self::num($r->kelembapan_udara, 0) . '%',
                'text'  => 'DHT11',
                'badge' => 'Normal',
            ],
        ];

        // Status keseluruhan = level tertinggi dari sensor penentu.
        $level = 'normal';
        $judul = 'Sistem Normal';
        $judulMap = [
            'getaran'          => ['waspada' => 'Getaran Lemah Terdeteksi', 'awas' => 'Getaran Terdeteksi'],
            'kemiringan'       => ['waspada' => 'Kemiringan berubah',       'awas' => 'Kemiringan Berbahaya'],
            'kelembapan_tanah' => ['waspada' => 'Tanah Mulai Jenuh',        'awas' => 'Tanah Sangat Jenuh'],
        ];
        foreach (['getaran', 'kemiringan', 'kelembapan_tanah'] as $key) {
            $lv = $sensors[$key]['level'];
            if (self::RANK[$lv] > self::RANK[$level]) {
                $level = $lv;
                $judul = $judulMap[$key][$lv];
            }
        }

        $copy = [
            'normal'  => ['Normal',  'Tidak ada indikasi longsor saat ini'],
            'waspada' => ['Waspada', 'Ada perubahan kondisi pada lereng'],
            'awas'    => ['Awas',    'Indikasi longsor terdeteksi, segera periksa lokasi'],
        ][$level];

        return [
            'level'      => $level,
            'label'      => $copy[0],
            'message'    => $copy[1],
            'judul'      => $judul,
            'popup_text' => self::popupText($judul, $level),
            'sensors'    => $sensors,
        ];
    }

    private static function popupText(string $judul, string $level): string
    {
        if ($level === 'normal') {
            return '';
        }
        $awal = $judul === 'Getaran Terdeteksi'
            ? 'Getaran terdeteksi pada lereng.'
            : $judul . ' pada lereng.';

        return $awal . "\nSegera periksa kondisi di lokasi";
    }

    private static function grade(float $value, array $limit): string
    {
        if ($value >= $limit['awas']) {
            return 'awas';
        }
        return $value >= $limit['waspada'] ? 'waspada' : 'normal';
    }

    private static function trim(string $n): string
    {
        return str_contains($n, ',') ? rtrim(rtrim($n, '0'), ',') : $n;
    }

    /** Angka ala Indonesia (koma desimal), tanpa nol di belakang koma kecuali getaran 0,0. */
    public static function num(float $v, int $dec): string
    {
        return number_format($v, $dec, ',', '.');
    }
}
