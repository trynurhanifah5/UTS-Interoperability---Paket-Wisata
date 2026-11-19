<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaketWisata extends Model
{
    protected $table = 'paket_wisata';

    protected $fillable = [
        'destinasi_id', 'nama_paket', 'durasi_hari',
        'harga', 'fasilitas', 'kuota_peserta'
    ];

    // Format waktu sesuai ketentuan UTS: '05-11-2018 08:40:30'
    protected $casts = [
        'created_at' => 'datetime:d-m-Y H:i:s',
        'updated_at' => 'datetime:d-m-Y H:i:s',
    ];

    public function destinasi()
    {
        return $this->belongsTo(Destinasi::class, 'destinasi_id', 'id');
    }
}