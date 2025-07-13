<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PenjualanItem;

class PenjualanItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (env('APP_ENV') == 'development') {
            PenjualanItem::truncate();
        }

        $data = [
            [
                'id_penjualan' => 1,
                'id_barang' => 1,
                'qty' => 2,
            ],
            [
                'id_penjualan' => 1,
                'id_barang' => 2,
                'qty' => 2,
            ],
            [
                'id_penjualan' => 2,
                'id_barang' => 6,
                'qty' => 1,
            ],
            [
                'id_penjualan' => 3,
                'id_barang' => 4,
                'qty' => 1,
            ],
            [
                'id_penjualan' => 3,
                'id_barang' => 7,
                'qty' => 1,
            ],
            [
                'id_penjualan' => 3,
                'id_barang' => 6,
                'qty' => 1,
            ],
            [
                'id_penjualan' => 4,
                'id_barang' => 9,
                'qty' => 2,
            ],
            [
                'id_penjualan' => 4,
                'id_barang' => 10,
                'qty' => 2,
            ],
            [
                'id_penjualan' => 5,
                'id_barang' => 3,
                'qty' => 1,
            ],
            [
                'id_penjualan' => 6,
                'id_barang' => 7,
                'qty' => 1,
            ],
            [
                'id_penjualan' => 6,
                'id_barang' => 5,
                'qty' => 1,
            ],
            [
                'id_penjualan' => 6,
                'id_barang' => 3,
                'qty' => 1,
            ],
            [
                'id_penjualan' => 7,
                'id_barang' => 5,
                'qty' => 1,
            ],
            [
                'id_penjualan' => 7,
                'id_barang' => 6,
                'qty' => 1,
            ],
            [
                'id_penjualan' => 7,
                'id_barang' => 7,
                'qty' => 1,
            ],
            [
                'id_penjualan' => 7,
                'id_barang' => 8,
                'qty' => 1,
            ],
            [
                'id_penjualan' => 8,
                'id_barang' => 5,
                'qty' => 1,
            ],
            [
                'id_penjualan' => 8,
                'id_barang' => 9,
                'qty' => 1,
            ],
            [
                'id_penjualan' => 9,
                'id_barang' => 5,
                'qty' => 1,
            ],
            [
                'id_penjualan' => 10,
                'id_barang' => 5,
                'qty' => 10,
            ],
        ];

        PenjualanItem::insert($data);
    }
}
