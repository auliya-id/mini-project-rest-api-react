<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Penjualan;

class PenjualanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (env('APP_ENV') == 'development') {
            Penjualan::truncate();
        }

        $data = [
            [
                'id_pelanggan' => 1,
                'kode_nota' => 'NOTA1',
                'tanggal' => '2018-01-01',
                'subtotal' => 50000,
            ],
            [
                'id_pelanggan' => 2,
                'kode_nota' => 'NOTA2',
                'tanggal' => '2018-01-01',
                'subtotal' => 200000,
            ],
            [
                'id_pelanggan' => 3,
                'kode_nota' => 'NOTA3',
                'tanggal' => '2018-01-01',
                'subtotal' => 430000,
            ],
            [
                'id_pelanggan' => 7,
                'kode_nota' => 'NOTA4',
                'tanggal' => '2018-01-02',
                'subtotal' => 120000,
            ],
            [
                'id_pelanggan' => 4,
                'kode_nota' => 'NOTA5',
                'tanggal' => '2018-01-02',
                'subtotal' => 70000,
            ],
            [
                'id_pelanggan' => 8,
                'kode_nota' => 'NOTA6',
                'tanggal' => '2018-01-03',
                'subtotal' => 230000,
            ],
            [
                'id_pelanggan' => 9,
                'kode_nota' => 'NOTA7',
                'tanggal' => '2018-01-03',
                'subtotal' => 390000,
            ],
            [
                'id_pelanggan' => 5,
                'kode_nota' => 'NOTA8',
                'tanggal' => '2018-01-03',
                'subtotal' => 65000,
            ],
            [
                'id_pelanggan' => 2,
                'kode_nota' => 'NOTA9',
                'tanggal' => '2018-01-04',
                'subtotal' => 40000,
            ],
            [
                'id_pelanggan' => 10,
                'kode_nota' => 'NOTA10',
                'tanggal' => '2018-01-04',
                'subtotal' => 40000,
            ],
        ];

        Penjualan::insert($data);
    }
}
