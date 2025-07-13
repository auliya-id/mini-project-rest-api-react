<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pelanggan;

class PelangganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (env('APP_ENV') == 'development') {
            Pelanggan::truncate();
        }

        $data = [
            [
                'kode_pelanggan' => 'PELANGGAN1',
                'nama_pelanggan' => 'ANDI',
                'domisili' => 'JAK-UT',
                'jenis_kelamin' => 'PRIA',
            ],
            [
                'kode_pelanggan' => 'PELANGGAN2',
                'nama_pelanggan' => 'BUDI',
                'domisili' => 'JAK-BAR',
                'jenis_kelamin' => 'PRIA',
            ],
            [
                'kode_pelanggan' => 'PELANGGAN3',
                'nama_pelanggan' => 'JOHAN',
                'domisili' => 'JAK-SEL',
                'jenis_kelamin' => 'PRIA',
            ],
            [
                'kode_pelanggan' => 'PELANGGAN4',
                'nama_pelanggan' => 'SINTHA',
                'domisili' => 'JAK-TIM',
                'jenis_kelamin' => 'WANITA',
            ],
            [
                'kode_pelanggan' => 'PELANGGAN5',
                'nama_pelanggan' => 'ANTO',
                'domisili' => 'JAK-UT',
                'jenis_kelamin' => 'PRIA',
            ],
            [
                'kode_pelanggan' => 'PELANGGAN6',
                'nama_pelanggan' => 'BUJANG',
                'domisili' => 'JAK-BAR',
                'jenis_kelamin' => 'PRIA',
            ],
            [
                'kode_pelanggan' => 'PELANGGAN7',
                'nama_pelanggan' => 'JOWAN',
                'domisili' => 'JAK-SEL',
                'jenis_kelamin' => 'PRIA',
            ],
            [
                'kode_pelanggan' => 'PELANGGAN8',
                'nama_pelanggan' => 'SINTIA',
                'domisili' => 'JAK-TIM',
                'jenis_kelamin' => 'WANITA',
            ],
            [
                'kode_pelanggan' => 'PELANGGAN9',
                'nama_pelanggan' => 'BUTET',
                'domisili' => 'JAK-BAR',
                'jenis_kelamin' => 'WANITA',
            ],
            [
                'kode_pelanggan' => 'PELANGGAN10',
                'nama_pelanggan' => 'JONNY',
                'domisili' => 'JAK-SEL',
                'jenis_kelamin' => 'WANITA',
            ],
        ];

        Pelanggan::insert($data);
    }
}
