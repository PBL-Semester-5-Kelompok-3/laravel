<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'username' => 'nurulmustofa', // Ganti sesuai kebutuhan
            'profile_picture' => null, // Bisa diisi dengan path gambar jika ada
            'email' => 'muhnurulmustofa@gmail.com', // Ganti sesuai kebutuhan
            'password' => Hash::make('password'), // Hash password
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
