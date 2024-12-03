<?php

namespace Database\Seeders;

use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class TransaksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $startDate = Carbon::create(2024, 11, 1); // Menentukan startDate = 2024-11-01
        $endDate = Carbon::create(2024, 11, 10); // Menentukan endDate = 2024-11-10

        // Iterasi dari startDate hingga endDate
        for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
            $numberOfTransactions = $faker->numberBetween(15, 20); // Menghasilkan angka acak antara 15 - 20 transaksi

            for ($i = 0; $i < $numberOfTransactions; $i++) {
                Transaksi::create([
                    'tanggal_pembelian' => $date->format('Y-m-d'),
                    'total_harga' => 0, // Total harga diisi 0 sesuai dengan kode Anda
                    'bayar' => 0,       // Bayar diisi 0 sesuai dengan kode Anda
                    'kembalian' => 0,   // Kembalian diisi 0 sesuai dengan kode Anda
                ]);
            }
        }
    }
}