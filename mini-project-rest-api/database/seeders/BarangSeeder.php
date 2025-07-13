<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Barang;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (env('APP_ENV') == 'development') {
            Barang::truncate();
        }

        $data = [
            [
                'kode_barang' => 'BRG1',
                'nama_barang' => 'PEN',
                'kategori' => 'ATK',
                'harga' => '15000',
            ],
            [
                'kode_barang' => 'BRG2',
                'nama_barang' => 'PENSIL',
                'kategori' => 'ATK',
                'harga' => '10000',
            ],
            [
                'kode_barang' => 'BRG3',
                'nama_barang' => 'PAYUNG',
                'kategori' => 'RT',
                'harga' => '70000',
            ],
            [
                'kode_barang' => 'BRG4',
                'nama_barang' => 'PANCI',
                'kategori' => 'MASAK',
                'harga' => '110000',
            ],
            [
                'kode_barang' => 'BRG5',
                'nama_barang' => 'SAPU',
                'kategori' => 'RT',
                'harga' => '40000',
            ],
            [
                'kode_barang' => 'BRG6',
                'nama_barang' => 'KIPAS',
                'kategori' => 'ELEKTRONIK',
                'harga' => '200000',
            ],
            [
                'kode_barang' => 'BRG7',
                'nama_barang' => 'KUALI',
                'kategori' => 'MASAK',
                'harga' => '120000',
            ],
            [
                'kode_barang' => 'BRG8',
                'nama_barang' => 'SIKAT',
                'kategori' => 'RT',
                'harga' => '30000',
            ],
            [
                'kode_barang' => 'BRG9',
                'nama_barang' => 'GELAS',
                'kategori' => 'RT',
                'harga' => '25000',
            ],
            [
                'kode_barang' => 'BRG10',
                'nama_barang' => 'PIRING',
                'kategori' => 'RT',
                'harga' => '35000',
            ],
        ];

        Barang::insert($data);
    }
}
