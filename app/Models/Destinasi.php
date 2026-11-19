<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Destinasi extends Model
{
    protected $table = 'destinasi';

    protected $fillable = [
        'kode_destinasi', 'nama_destinasi', 'provinsi', 'kota_kabupaten',
        'kategori_wisata', 'alamat_lengkap', 'jam_operasional',
        'deskripsi', 'status_aktif'
    ];

    // Format waktu sesuai ketentuan UTS: '05-11-2018 08:40:30'
    protected $casts = [
        'created_at' => 'datetime:d-m-Y H:i:s',
        'updated_at' => 'datetime:d-m-Y H:i:s',
    ];

    // Relasi: 1 Destinasi memiliki banyak Paket Wisata
    public function paketWisata()
    {
        return $this->hasMany(PaketWisata::class, 'destinasi_id', 'id');
    }
}