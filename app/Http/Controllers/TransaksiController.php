<?php

namespace App\Http\Controllers;

use App\Models\TransaksiDetail;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    public function index()
    {
        // Menampilkan transaksi terbaru
        $transaksi = Transaksi::orderBy('tanggal_pembelian', 'DESC')->get();

        return view('transaksi.index', compact('transaksi'));
    }

    public function create()
    {
        return view('transaksi.create');
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'tanggal_pembelian' => 'required|date',
            'bayar' => 'required|numeric',
            'nama_produk1' => 'required|string',
            'harga_satuan1' => 'required|numeric',
            'jumlah1' => 'required|numeric',
            'nama_produk2' => 'required|string',
            'harga_satuan2' => 'required|numeric',
            'jumlah2' => 'required|numeric',
            'nama_produk3' => 'required|string',
            'harga_satuan3' => 'required|numeric',
            'jumlah3' => 'required|numeric',
        ]);

        // Mulai transaksi untuk memastikan konsistensi data
        DB::beginTransaction();

        try {
            // Menyimpan data transaksi
            $transaksi = new Transaksi();
            $transaksi->tanggal_pembelian = $request->input('tanggal_pembelian');
            $transaksi->total_harga = 0; // Akan dihitung di bawah
            $transaksi->bayar = $request->input('bayar');
            $transaksi->kembalian = 0; // Akan dihitung di bawah
            $transaksi->save();

            $total_harga = 0;
            $jumlah_produk = 3; // Misalnya kita menerima 3 produk, sesuaikan sesuai input dari form

            // Menyimpan detail transaksi
            for ($i = 1; $i <= $jumlah_produk; $i++) {
                $transaksidetail = new TransaksiDetail();
                $transaksidetail->id_transaksi = $transaksi->id;
                $transaksidetail->nama_produk = $request->input('nama_produk'.$i);
                $transaksidetail->harga_satuan = $request->input('harga_satuan'.$i);
                $transaksidetail->jumlah = $request->input('jumlah'.$i);
                $transaksidetail->subtotal = $request->input('harga_satuan'.$i) * $request->input('jumlah'.$i);
                $total_harga += $transaksidetail->subtotal;
                $transaksidetail->save(); // Simpan detail transaksi
            }

            // Update total harga dan kembalian transaksi
            $transaksi->total_harga = $total_harga;
            $transaksi->kembalian = $transaksi->bayar - $total_harga;
            $transaksi->save(); // Simpan perubahan transaksi

            // Commit transaksi jika berhasil
            DB::commit();

            return redirect('transaksidetail/'.$transaksi->id)->with('pesan', 'Berhasil menambahkan data transaksi');
        } catch (\Exception $e) {
            // Rollback jika terjadi error
            DB::rollback();
            return redirect()->back()->withErrors(['Transaction' => 'Gagal menambahkan data transaksi'])->withInput();
        }
    }

    public function edit($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        return view('transaksi.edit', compact('transaksi'));
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'bayar' => 'required|numeric',
        ]);

        // Cari transaksi berdasarkan ID
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->bayar = $request->input('bayar');
        $transaksi->kembalian = $transaksi->bayar - $transaksi->total_harga;

        $transaksi->save(); // Simpan perubahan transaksi

        return redirect('/transaksi')->with('pesan', 'Berhasil mengubah data transaksi');
    }

    public function destroy($id)
    {
        // Cari transaksi berdasarkan ID dan hapus
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->delete();

        return redirect('/transaksi')->with('pesan', 'Berhasil menghapus transaksi');
    }
}