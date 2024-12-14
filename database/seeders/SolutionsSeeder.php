<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SolutionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Daftar penyakit dan solusi terkait
        $diseaseSolutions = [
            'Bacterial_spot' => [
                [
                    'title' => 'Penggunaan Benih Bebas Penyakit',
                    'keterangan_solution' => 'Gunakan benih atau bibit yang bebas penyakit dan bersertifikat untuk mencegah infeksi awal.',
                ],
                [
                    'title' => 'Rotasi Tanaman',
                    'keterangan_solution' => 'Terapkan rotasi tanaman untuk mencegah akumulasi patogen di tanah.',
                ],
                [
                    'title' => 'Aplikasi Bakterisida',
                    'keterangan_solution' => 'Semprotkan bakterisida sesuai dosis yang dianjurkan untuk mengendalikan penyebaran bakteri.',
                ],
            ],
            'Early_blight' => [
                [
                    'title' => 'Sanitasi Lahan',
                    'keterangan_solution' => 'Bersihkan sisa-sisa tanaman yang terinfeksi untuk mencegah sumber inokulum.',
                ],
                [
                    'title' => 'Penggunaan Fungisida',
                    'keterangan_solution' => 'Aplikasikan fungisida berbahan aktif mancozeb atau chlorothalonil secara berkala.',
                ],
                [
                    'title' => 'Penanaman Varietas Tahan',
                    'keterangan_solution' => 'Pilih varietas tomat yang memiliki ketahanan terhadap penyakit hawar awal.',
                ],
            ],
            'healthy' => [
                [
                    'title' => 'Pemeliharaan Rutin',
                    'keterangan_solution' => 'Lakukan pemeliharaan rutin seperti penyiraman dan pemupukan sesuai kebutuhan.',
                ],
                [
                    'title' => 'Pengendalian Hama',
                    'keterangan_solution' => 'Pantau dan kendalikan hama secara teratur untuk mencegah potensi infeksi penyakit.',
                ],
                [
                    'title' => 'Pemberian Nutrisi Tambahan',
                    'keterangan_solution' => 'Berikan nutrisi tambahan sesuai kebutuhan tanaman untuk menjaga kesehatannya.',
                ],
            ],
            'Late_blight' => [
                [
                    'title' => 'Penggunaan Fungisida Sistemik',
                    'keterangan_solution' => 'Semprotkan fungisida sistemik berbahan aktif metalaksil setiap 10 hari sekali.',
                ],
                [
                    'title' => 'Penggunaan Fungisida Kontak',
                    'keterangan_solution' => 'Semprotkan fungisida kontak berbahan aktif mancozeb setiap 5 hari sekali.',
                ],
                [
                    'title' => 'Pengurangan Kelembaban',
                    'keterangan_solution' => 'Kurangi kelembaban pada lahan tanam untuk mencegah perkembangan jamur.',
                ],
            ],
            'Leaf_Mold' => [
                [
                    'title' => 'Ventilasi yang Baik',
                    'keterangan_solution' => 'Pastikan sirkulasi udara yang baik di sekitar tanaman untuk mengurangi kelembaban.',
                ],
                [
                    'title' => 'Penggunaan Fungisida',
                    'keterangan_solution' => 'Aplikasikan fungisida yang efektif terhadap cendawan penyebab Leaf Mold.',
                ],
                [
                    'title' => 'Pemangkasan Daun Tua',
                    'keterangan_solution' => 'Pangkas daun-daun tua yang terinfeksi untuk mencegah penyebaran penyakit.',
                ],
            ],
            'mosaic_virus' => [
                [
                    'title' => 'Pengendalian Vektor',
                    'keterangan_solution' => 'Kendalikan vektor seperti kutu daun dengan insektisida ramah lingkungan.',
                ],
                [
                    'title' => 'Penggunaan Benih Tahan Virus',
                    'keterangan_solution' => 'Tanam varietas tomat yang tahan terhadap infeksi virus mosaik.',
                ],
                [
                    'title' => 'Sanitasi Lahan',
                    'keterangan_solution' => 'Bersihkan gulma dan sisa tanaman yang berpotensi menjadi tempat berkembang biaknya vektor.',
                ],
            ],
            'Septoria_leaf_spot' => [
                [
                    'title' => 'Penggunaan Fungisida',
                    'keterangan_solution' => 'Semprotkan fungisida berbahan aktif seperti mancozeb untuk mengendalikan Septoria.',
                ],
                [
                    'title' => 'Pengurangan Kelembaban',
                    'keterangan_solution' => 'Pastikan tanaman memiliki jarak tanam yang cukup untuk mengurangi kelembaban.',
                ],
                [
                    'title' => 'Rotasi Tanaman',
                    'keterangan_solution' => 'Lakukan rotasi tanaman untuk mencegah akumulasi patogen.',
                ],
            ],
            'Spider_mites Two-spotted_spider_mite' => [
                [
                    'title' => 'Penggunaan Akarisida',
                    'keterangan_solution' => 'Aplikasikan akarisida untuk mengendalikan tungau secara efektif.',
                ],
                [
                    'title' => 'Pengendalian Secara Mekanis',
                    'keterangan_solution' => 'Gunakan air bertekanan untuk mengusir tungau dari tanaman.',
                ],
                [
                    'title' => 'Pengurangan Kelembaban',
                    'keterangan_solution' => 'Kurangi kelembaban di sekitar tanaman untuk menghambat perkembangan tungau.',
                ],
            ],
            'Target_Spot' => [
                [
                    'title' => 'Penggunaan Fungisida Kontak',
                    'keterangan_solution' => 'Semprotkan fungisida kontak berbahan aktif chlorothalonil.',
                ],
                [
                    'title' => 'Pengendalian Gulma',
                    'keterangan_solution' => 'Bersihkan gulma di sekitar lahan untuk mencegah penyebaran penyakit.',
                ],
                [
                    'title' => 'Sanitasi Lahan',
                    'keterangan_solution' => 'Bersihkan sisa tanaman yang terinfeksi untuk mencegah penyebaran penyakit.',
                ],
            ],
            'Yellow_Leaf_Curl_Virus' => [
                [
                    'title' => 'Pengendalian Kutu Kebul',
                    'keterangan_solution' => 'Kendalikan kutu kebul dengan perangkap kuning atau insektisida ramah lingkungan.',
                ],
                [
                    'title' => 'Tanam Varietas Tahan Virus',
                    'keterangan_solution' => 'Gunakan varietas tomat yang tahan terhadap virus keriting kuning.',
                ],
                [
                    'title' => 'Pengelolaan Gulma',
                    'keterangan_solution' => 'Bersihkan gulma yang menjadi inang kutu kebul di sekitar tanaman.',
                ],
            ],
        ];

        // Loop untuk memasukkan data ke tabel solutions
        foreach ($diseaseSolutions as $disease => $solutions) {
            $diseaseId = DB::table('diseases')->where('name', $disease)->value('id');

            foreach ($solutions as $solution) {
                DB::table('solutions')->insert([
                    'title' => $solution['title'],
                    'keterangan_solution' => $solution['keterangan_solution'],
                    'id_disease' => $diseaseId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
