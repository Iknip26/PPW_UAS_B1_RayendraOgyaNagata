<?php

namespace App\Http\Controllers;

use App\Models\Transaksi; // Pastikan Anda mengimpor model Transaksi

class DashboardController extends Controller
{
    public function index()
    {
        // Menghitung jumlah transaksi
        $transaksi_count = Transaksi::count(); // Menampilkan jumlah transaksi yang ada

        // Mengirim data ke view
        return view('dashboard', compact('transaksi_count')); // Mengirim variabel transaksi_count ke view
    }
}