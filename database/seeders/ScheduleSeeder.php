<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Array keterangan khusus untuk perawatan tanaman tomat
        $keteranganList = [
            'Pemeriksaan Hama dan Penyakit',
            'Penyiraman Tanaman Secara Rutin',
            'Pemangkasan Daun Tua',
            'Pemberian Pupuk Organik',
            'Pengikatan Batang pada Ajir',
            'Pembersihan Gulma di Sekitar Tanaman',
            'Pemangkasan Tunas Liar',
            'Pengecekan pH dan Kelembapan Tanah',
            'Pemberian Nutrisi Tambahan',
            'Panen Buah Tomat Matang',
        ];

        // Loop untuk setiap id_disease dari 1 sampai 10
        for ($id_disease = 1; $id_disease <= 10; $id_disease++) {
            // Acak waktu mulai antara 07:00 dan 16:00
            for ($i = 1; $i <= 3; $i++) {
                $startHour = rand(7, 16);
                $startTime = sprintf('%02d:00', $startHour); // Format waktu mulai
                $endTime = sprintf('%02d:00', $startHour + 2); // Waktu selesai 2 jam setelahnya

                // Acak keterangan
                $keterangan = $keteranganList[array_rand($keteranganList)];

                // Insert ke database
                DB::table('schedules')->insert([
                    'time' => $startTime . ' - ' . $endTime,
                    'keterangan' => $keterangan,
                    'id_disease' => $id_disease,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
