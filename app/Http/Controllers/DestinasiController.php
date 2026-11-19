<?php

namespace App\Http\Controllers;

use App\Models\Destinasi;
use Illuminate\Http\Request;

class DestinasiController extends Controller
{
    public function index(Request $request)
    {
        $data = Destinasi::all();
        return $this->dynamicResponse($request, $data, 200);
    }

    public function show(Request $request, $destinasiId)
    {
        $destinasi = Destinasi::with('paketWisata')->find($destinasiId);
        if (!$destinasi) {
            return $this->dynamicResponse($request, ['message' => 'Destinasi tidak ditemukan'], 404);
        }
        return $this->dynamicResponse($request, $destinasi, 200);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'kode_destinasi' => 'required|unique:destinasi',
            'nama_destinasi' => 'required',
            'provinsi'       => 'required',
            'kota_kabupaten' => 'required',
        ]);

        $destinasi = Destinasi::create($request->all());
        return $this->dynamicResponse($request, [
            'message' => 'Destinasi berhasil ditambahkan',
            'data'    => $destinasi
        ], 201);
    }

    public function update(Request $request, $destinasiId)
    {
        $destinasi = Destinasi::find($destinasiId);
        if (!$destinasi) {
            return $this->dynamicResponse($request, ['message' => 'Destinasi tidak ditemukan'], 404);
        }

        $destinasi->update($request->all());
        return $this->dynamicResponse($request, [
            'message' => 'Destinasi berhasil diperbarui',
            'data'    => $destinasi
        ], 200);
    }

    public function destroy(Request $request, $destinasiId)
    {
        $destinasi = Destinasi::find($destinasiId);
        if (!$destinasi) {
            return $this->dynamicResponse($request, ['message' => 'Destinasi tidak ditemukan'], 404);
        }

        $destinasi->delete();
        return $this->dynamicResponse($request, ['message' => 'Destinasi berhasil dihapus'], 200);
    }
}