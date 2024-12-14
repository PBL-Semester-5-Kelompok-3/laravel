<?php

namespace Database\Seeders;

use App\Models\Disease;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DiseaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $diseases = [
            'Bacterial_spot',
            'Early_blight',
            'healthy',
            'Late_blight',
            'Leaf_Mold',
            'mosaic_virus',
            'Septoria_leaf_spot',
            'Spider_mites Two-spotted_spider_mite',
            'Target_Spot',
            'Yellow_Leaf_Curl_Virus',
        ];

        foreach ($diseases as $disease) {
            Disease::create(['name' => $disease]);
        }
    }
}
