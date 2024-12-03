<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // Import SoftDeletes

class Transaksi extends Model
{
    use HasFactory, SoftDeletes; // Gunakan SoftDeletes untuk soft delete

    protected $table = 'transaksi';  // Menyebutkan nama tabel

    protected $fillable = [
        'tanggal_pembelian',
        'total_harga',
        'bayar',
        'kembalian',
    ];

    protected $dates = ['deleted_at']; // Pastikan kolom deleted_at dikenali sebagai kolom tanggal

    /**
     * Relasi dengan model TransaksiDetail
     */
    public function transaksidetail()
    {
        return $this->hasMany(TransaksiDetail::class, 'id_transaksi', 'id'); // Relasi One to Many
    }
}