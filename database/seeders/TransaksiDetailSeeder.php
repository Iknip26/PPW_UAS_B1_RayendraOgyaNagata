<?php

namespace Database\Seeders;

use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use Bezhanov\Faker\Provider\Commerce;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class TransaksiDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $faker->addProvider(new Commerce($faker));

        $transaksi = Transaksi::all();

        foreach ($transaksi as $t) {
            $numberOfDetails = $faker->numberBetween(5, 15); // Jumlah detail transaksi acak antara 5-15
            $total_harga = 0;

            for ($j = 0; $j < $numberOfDetails; $j++) {
                $hargaSatuan = $faker->numberBetween(10, 500) * 100; // Harga satuan acak
                $jumlah = $faker->numberBetween(1, 5); // Jumlah acak antara 1 - 5
                $subtotal = $hargaSatuan * $jumlah; // Menghitung subtotal
                $total_harga += $subtotal; // Menambahkan subtotal ke total_harga

                TransaksiDetail::create([ // Menyimpan transaksi detail
                    'id_transaksi' => $t->id,
                    'nama_produk' => $faker->productName, // Nama produk acak
                    'harga_satuan' => $hargaSatuan,
                    'jumlah' => $jumlah,
                    'subtotal' => $subtotal, // Menambahkan subtotal
                ]);
            }

            // Mengupdate total_harga, bayar, dan kembalian pada transaksi
            $t->total_harga = $total_harga;
            $t->bayar = ceil($total_harga / 50000) * 50000; // Membulatkan bayar ke kelipatan 50,000
            $t->kembalian = $t->bayar - $total_harga; // Menghitung kembalian
            $t->save(); // Menyimpan perubahan pada transaksi
        }
    }
}