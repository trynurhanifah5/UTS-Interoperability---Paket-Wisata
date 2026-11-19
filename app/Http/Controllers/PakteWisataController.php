<?php

namespace App\Http\Controllers;

use App\Models\PaketWisata;
use Illuminate\Http\Request;

class PaketWisataController extends Controller
{
    public function index(Request $request)
    {
        $query = PaketWisata::with('destinasi');

        // Filter berdasarkan destinasi_id jika parameter dikirim (Contoh: /paket-wisata?destinasi_id=1)
        if ($request->has('destinasi_id')) {
            $query->where('destinasi_id', $request->query('destinasi_id'));
        }

        $data = $query->get();
        return $this->dynamicResponse($request, $data, 200);
    }

    public function show(Request $request, $paketId)
    {
        $paket = PaketWisata::with('destinasi')->find($paketId);
        if (!$paket) {
            return $this->dynamicResponse($request, ['message' => 'Paket wisata tidak ditemukan'], 404);
        }
        return $this->dynamicResponse($request, $paket, 200);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'destinasi_id'  => 'required|exists:destinasi,id',
            'nama_paket'    => 'required',
            'durasi_hari'   => 'required|integer',
            'harga'         => 'required|numeric',
            'fasilitas'     => 'required',
            'kuota_peserta' => 'required|integer',
        ]);

        $paket = PaketWisata::create($request->all());
        return $this->dynamicResponse($request, [
            'message' => 'Paket wisata berhasil dibuat',
            'data'    => $paket
        ], 201);
    }

    public function update(Request $request, $paketId)
    {
        $paket = PaketWisata::find($paketId);
        if (!$paket) {
            return $this->dynamicResponse($request, ['message' => 'Paket wisata tidak ditemukan'], 404);
        }

        $paket->update($request->all());
        return $this->dynamicResponse($request, [
            'message' => 'Paket wisata berhasil diperbarui',
            'data'    => $paket
        ], 200);
    }

    public function destroy(Request $request, $paketId)
    {
        $paket = PaketWisata::find($paketId);
        if (!$paket) {
            return $this->dynamicResponse($request, ['message' => 'Paket wisata tidak ditemukan'], 404);
        }

        $paket->delete();
        return $this->dynamicResponse($request, ['message' => 'Paket wisata berhasil dihapus'], 200);
    }
}