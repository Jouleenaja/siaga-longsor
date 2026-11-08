<?php

namespace App\Http\Controllers;

use App\Models\Riwayat;
use App\Models\SensorReading;
use App\Services\SlopeStatus;

class PageController extends Controller
{
    public function beranda()
    {
        $reading = SensorReading::latestOrDefault();
        $status  = SlopeStatus::evaluate($reading);

        return view('beranda', compact('reading', 'status'));
    }

    public function sensor()
    {
        $reading = SensorReading::latestOrDefault();
        $status  = SlopeStatus::evaluate($reading);

        return view('sensor', compact('reading', 'status'));
    }

    public function riwayat()
    {
        $riwayats = Riwayat::orderByDesc('occurred_at')->limit(50)->get();

        return view('riwayat', compact('riwayats'));
    }
}
