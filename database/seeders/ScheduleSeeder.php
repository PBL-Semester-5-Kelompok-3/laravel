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
            // Acak keterangan
            $keterangan = $keteranganList[array_rand($keteranganList)];

            // Insert ke database
            DB::table('schedules')->insert([
                'keterangan' => $keterangan,
                'id_disease' => $id_disease,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
