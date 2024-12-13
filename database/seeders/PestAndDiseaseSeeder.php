<?php

namespace Database\Seeders;

use App\Models\PestAndDisease;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class PestAndDiseaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < 10; $i++) {
            PestAndDisease::create([
                'name' => $faker->word,
                'description' => $faker->sentence,
                'warning' => $faker->sentence,
                'genus' => $faker->word,
                'scientific_name' => $faker->word . ' ' . $faker->word,
                'aliases' => $faker->words(3, true),
                'symptoms' => $faker->sentences(3, true),
                'solutions' => json_encode([$faker->sentence, $faker->sentence, $faker->sentence]),
                'source' => $faker->url,
            ]);
        }
    }
}
