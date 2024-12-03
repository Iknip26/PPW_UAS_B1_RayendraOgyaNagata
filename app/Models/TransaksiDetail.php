<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // Jika menggunakan SoftDeletes

class TransaksiDetail extends Model
{
    use HasFactory, SoftDeletes; // Pastikan ada titik koma dan SoftDeletes

    protected $table = 'transaksi_detail';

    protected $fillable = [ // Tambahkan 'protected' agar dapat diakses
        'id_transaksi',
        'nama_produk',
        'harga_satuan',
        'jumlah',
        'subtotal',
    ];

    protected $dates = ['deleted_at']; // Jika menggunakan soft delete

    /**
     * Relasi dengan model Transaksi
     */
    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'id_transaksi', 'id'); // Perbaiki 'this-belongsTo' menjadi 'this->belongsTo'
    }
}