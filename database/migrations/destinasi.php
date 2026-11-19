<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('destinasi', function (Blueprint $table) {
            $table->increments('id');
            $table->string('kode_destinasi')->unique();
            $table->string('nama_destinasi');
            $table->string('provinsi');
            $table->string('kota_kabupaten');
            $table->string('kategori_wisata');
            $table->text('alamat_lengkap');
            $table->string('jam_operasional');
            $table->text('deskripsi');
            $table->string('status_aktif')->default('Aktif');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('destinasi');
    }
};