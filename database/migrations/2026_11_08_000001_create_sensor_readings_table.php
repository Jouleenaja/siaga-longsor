<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sensor_readings', function (Blueprint $table) {
            $table->id();
            $table->float('kemiringan')->default(0);        // derajat
            $table->float('getaran')->default(0);           // satuan g
            $table->float('kelembapan_tanah')->default(0);  // persen
            $table->float('suhu')->default(0);              // celcius
            $table->float('kelembapan_udara')->default(0);  // persen
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sensor_readings');
    }
};
