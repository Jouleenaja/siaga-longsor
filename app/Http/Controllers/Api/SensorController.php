<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Riwayat;
use App\Models\SensorReading;
use App\Services\SlopeStatus;
use Illuminate\Http\Request;

class SensorController extends Controller
{
    /** Dipanggil alat (ESP32/Arduino) untuk mengirim data sensor. */
    public function store(Request $request)
    {
        $key = config('siaga.api_key');
        if ($key && $request->header('X-API-KEY') !== $key) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $data = $request->validate([
            'kemiringan'       => 'required|numeric',
            'getaran'          => 'required|numeric|min:0',
            'kelembapan_tanah' => 'required|numeric|between:0,100',
            'suhu'             => 'required|numeric',
            'kelembapan_udara' => 'required|numeric|between:0,100',
        ]);

        $reading = SensorReading::create($data);
        $status  = SlopeStatus::evaluate($reading);

        // Catat ke riwayat hanya saat kondisi berubah.
        $last = Riwayat::orderByDesc('id')->first();
        if (! $last || $last->level !== $status['level'] || $last->judul !== $status['judul']) {
            Riwayat::create([
                'judul'       => $status['judul'],
                'level'       => $status['level'],
                'occurred_at' => now(),
            ]);
        }

        return response()->json(['message' => 'OK', 'level' => $status['level']], 201);
    }

    /** Dipolling oleh halaman web untuk update otomatis & popup peringatan. */
    public function latest()
    {
        $reading = SensorReading::latestOrDefault();
        $status  = SlopeStatus::evaluate($reading);

        $eventId = null;
        if ($status['level'] === 'awas') {
            $eventId = Riwayat::where('level', 'awas')->orderByDesc('id')->value('id') ?? 0;
        }

        return response()->json([
            'reading_id' => $reading->id ?? 0,
            'level'      => $status['level'],
            'event_id'   => $eventId,
            'popup_text' => $status['popup_text'],
        ]);
    }
}
