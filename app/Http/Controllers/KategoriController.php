<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\SuratMasuk;
use App\Models\SuratKeluar;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        $kategori = Kategori::all();
        return response()->json($kategori);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'singkatan' => 'nullable|string|max:10',
        ]);

        $kategori = Kategori::create($request->only('nama', 'singkatan'));

        return response()->json(['message' => 'Kategori berhasil ditambah', 'data' => $kategori], 201);
    }

    public function show($id)
    {
        $kategori = Kategori::with(['suratMasuk', 'suratKeluar'])->find($id);

        if ($kategori) {
            return response()->json([
                'kategori' => $kategori,
                'surat_masuk' => $kategori->suratMasuk,
                'surat_keluar' => $kategori->suratKeluar,
            ]);
        } else {
            return response()->json(['message' => 'Kategori tidak ditemukan'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'singkatan' => 'nullable|string|max:10',
        ]);

        $kategori = Kategori::find($id);

        if ($kategori) {
            $kategori->update($request->only('nama', 'singkatan'));
            return response()->json(['message' => 'Kategori berhasil diupdate', 'data' => $kategori]);
        } else {
            return response()->json(['message' => 'Kategori tidak ditemukan'], 404);
        }
    }

    public function destroy($id)
    {
        $kategori = Kategori::find($id);

        if ($kategori) {
            $usedInSuratMasuk = SuratMasuk::where('kategori', $id)->exists();
            $usedInSuratKeluar = SuratKeluar::where('kategori', $id)->exists();

            if ($usedInSuratMasuk || $usedInSuratKeluar) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Kategori tidak dapat dihapus karena masih digunakan di surat.',
                ], 400);
            }

            $kategori->delete();
            return response()->json(['message' => 'Kategori berhasil dihapus']);
        } else {
            return response()->json(['message' => 'Kategori tidak ditemukan'], 404);
        }
    }
}
