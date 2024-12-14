<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Daftar penyakit dan hama yang terkait
        $diseasePestMap = [
            'Bacterial_spot' => [
                'Kutu Daun (Aphids)',
                'Kutu Kebul (Bemisia tabaci)',
                'Thrips (Thrips palmi)',
            ],
            'Early_blight' => [
                'Ulat Grayak (Spodoptera litura)',
                'Lalat Buah (Bactrocera spp.)',
                'Kutu Daun (Aphids)',
            ],
            'healthy' => [
                'Kutu Daun (Aphids)',
                'Kutu Kebul (Bemisia tabaci)',
                'Ulat Buah (Helicoverpa armigera)',
            ],
            'Late_blight' => [
                'Ulat Grayak (Spodoptera litura)',
                'Lalat Buah (Bactrocera spp.)',
                'Thrips (Thrips palmi)',
            ],
            'Leaf_Mold' => [
                'Kutu Kebul (Bemisia tabaci)',
                'Kutu Daun (Aphids)',
                'Ulat Tanah (Agrotis ipsilon)',
            ],
            'mosaic_virus' => [
                'Kutu Daun (Aphids)',
                'Thrips (Thrips palmi)',
                'Kutu Kebul (Bemisia tabaci)',
            ],
            'Septoria_leaf_spot' => [
                'Ulat Grayak (Spodoptera litura)',
                'Lalat Buah (Bactrocera spp.)',
                'Ulat Buah (Helicoverpa armigera)',
            ],
            'Spider_mites Two-spotted_spider_mite' => [
                'Tungau (Tetranychus spp.)',
                'Kutu Daun (Aphids)',
                'Thrips (Thrips palmi)',
            ],
            'Target_Spot' => [
                'Ulat Grayak (Spodoptera litura)',
                'Ulat Tanah (Agrotis ipsilon)',
                'Lalat Buah (Bactrocera spp.)',
            ],
            'Yellow_Leaf_Curl_Virus' => [
                'Kutu Kebul (Bemisia tabaci)',
                'Kutu Daun (Aphids)',
                'Thrips (Thrips palmi)',
            ],
        ];

        // Loop untuk setiap penyakit dan hama terkait
        foreach ($diseasePestMap as $disease => $pests) {
            // Dapatkan id_disease berdasarkan nama penyakit
            $diseaseId = DB::table('diseases')->where('name', $disease)->value('id');

            // Tambahkan setiap hama yang terkait dengan penyakit
            foreach ($pests as $pest) {
                DB::table('pest')->insert([
                    'name' => $pest,
                    'id_disease' => $diseaseId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
