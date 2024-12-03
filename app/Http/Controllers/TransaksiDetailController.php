<?php

namespace App\Http\Controllers;

use App\Models\TransaksiDetail;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use Illuminate\Support\Facades\DB;

class TransaksiDetailController extends Controller
{
    // Menampilkan Semua Detail Transaksi
    public function index()
    {
        // Mengambil semua data transaksi detail dan mengurutkannya berdasarkan ID terbaru
        $transaksidetail = TransaksiDetail::with('transaksi')->orderBy('id', 'DESC')->get();

        // Mengirim data transaksi detail ke view
        return view('transaksidetail.index', compact('transaksidetail'));
    }

    // Menampilkan Detail Transaksi Berdasarkan ID Transaksi
    public function detail(Request $request)
    {
        // Mencari transaksi berdasarkan ID yang diberikan dan termasuk detail transaksi terkait
        $transaksi = Transaksi::with('transaksidetail')->findOrFail($request->id_transaksi);

        // Mengirim data transaksi dan detail transaksi ke view
        return view('transaksidetail.detail', compact('transaksi'));
    }

    // Menampilkan Form Edit Transaksi Detail
    public function edit($id)
    {
        // Mencari transaksi detail berdasarkan ID yang diberikan
        $transaksidetail = TransaksiDetail::findOrFail($id);

        // Mengirim data transaksi detail ke view edit
        return view('transaksidetail.edit', compact('transaksidetail'));
    }

    // Memperbarui Data Transaksi Detail
    public function update(Request $request, $id)
    {
        // Validasi input dari form
        $request->validate([
            'nama_produk' => 'required|string',
            'harga_satuan' => 'required|numeric',
            'jumlah' => 'required|numeric',
        ]);

        // Mencari transaksi detail berdasarkan ID yang diberikan
        $transaksidetail = TransaksiDetail::findOrFail($id);
        $transaksi = Transaksi::findOrFail($transaksidetail->id_transaksi);

        // Gunakan transaction
        DB::beginTransaction();

        try {
            // Update data transaksi detail
            $transaksidetail->nama_produk = $request->input('nama_produk');
            $transaksidetail->harga_satuan = $request->input('harga_satuan');
            $transaksidetail->jumlah = $request->input('jumlah');
            $transaksidetail->subtotal = $transaksidetail->harga_satuan * $transaksidetail->jumlah;
            $transaksidetail->save(); // Simpan perubahan detail transaksi

            // Update total harga di transaksi
            $transaksi->total_harga = $transaksi->transaksidetail->sum('subtotal');
            $transaksi->kembalian = $transaksi->bayar - $transaksi->total_harga;
            $transaksi->save(); // Simpan perubahan transaksi

            // Commit transaksi jika berhasil
            DB::commit();

            return redirect('transaksidetail/'.$transaksidetail->id_transaksi)->with('pesan', 'Berhasil mengubah data transaksi detail');
        } catch (\Exception $e) {
            // Rollback jika terjadi error
            DB::rollback();
            return redirect()->back()->withErrors(['Transaction' => 'Gagal mengubah data transaksi detail'])->withInput();
        }
    }

    // Menghapus Data Transaksi Detail
    public function destroy($id)
    {
        // Mencari transaksi detail berdasarkan ID yang diberikan
        $transaksidetail = TransaksiDetail::findOrFail($id);
        $transaksi = Transaksi::findOrFail($transaksidetail->id_transaksi);

        // Gunakan transaction
        DB::beginTransaction();

        try {
            // Hapus transaksi detail
            $transaksidetail->delete();

            // Update total harga transaksi setelah detail dihapus
            $transaksi->total_harga = $transaksi->transaksidetail->sum('subtotal');
            $transaksi->kembalian = $transaksi->bayar - $transaksi->total_harga;
            $transaksi->save(); // Simpan perubahan transaksi

            // Commit transaksi jika berhasil
            DB::commit();

            return redirect('transaksidetail/'.$transaksi->id)->with('pesan', 'Berhasil menghapus data transaksi detail');
        } catch (\Exception $e) {
            // Rollback jika terjadi error
            DB::rollback();
            return redirect()->back()->withErrors(['Transaction' => 'Gagal menghapus data transaksi detail'])->withInput();
        }
    }
}