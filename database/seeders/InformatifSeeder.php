<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class InformatifSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat instance Faker
        $faker = Faker::create();

        // Daftar type yang akan digunakan
        $types = [
            'Planting',
            'Planting Training',
            'Site Selection',
            'Field Preparation',
            'Weeding',
            'Irrigation'
        ];

        foreach ($types as $type) {
            DB::table('informatifs')->insert([
                'title' => $faker->sentence, // Menggunakan Faker untuk generate title acak
                'type' => $type,
                'content' => 'https://picsum.photos/800/600?random=' . rand(1, 1000), // Mengambil gambar acak dari web
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
