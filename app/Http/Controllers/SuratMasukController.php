<?php

namespace App\Http\Controllers;

use App\Models\SuratMasuk;
use App\Models\Kategori;
use Illuminate\Http\Request;

class SuratMasukController extends Controller
{
    public function index()
    {
        $suratMasuk = SuratMasuk::with('kategori')->get();
        return response()->json($suratMasuk);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'pengirim' => 'required|string|max:255',
            'penerima' => 'required|string|max:255',
            'tanggal_terima' => 'required|date',
            'subject' => 'required|string|max:255',
            'isi_surat' => 'required|string',
            'status_surat' => 'required|string',
            'no_surat' => 'required|string|unique:surat_masuk,no_surat',
            'lampiran' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
            'kategori_id' => 'required|exists:kategori,id',
        ]);

        try {
            if ($request->hasFile('lampiran')) {
                $filePath = $request->file('lampiran')->store('lampiran', 'public');
                $validated['lampiran'] = $filePath;
            }

            $suratMasuk = SuratMasuk::create($validated);

            return response()->json(['message' => 'Surat berhasil ditambah', 'data' => $suratMasuk], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan saat menyimpan surat masuk', 'error' => $e->getMessage()], 500);
        }
    }




    // Menampilkan surat masuk berdasarkan ID
    public function show($id)
    {
        $suratMasuk = SuratMasuk::find($id);

        if ($suratMasuk) {
            if ($suratMasuk->lampiran) {
                $suratMasuk->lampiran = asset('storage/' . $suratMasuk->lampiran);
            }

            return response()->json($suratMasuk);
        } else {
            return response()->json(['message' => 'Surat tidak ditemukan'], 404);
        }
    }


    // Mengupdate surat masuk berdasarkan ID
    public function update(Request $request, $id)
    {
        // Validasi input
        $validated = $request->validate([
            'pengirim' => 'required|string|max:255',
            'penerima' => 'required|string|max:255',
            'tanggal_terima' => 'required|date',
            'subject' => 'required|string|max:255',
            'isi_surat' => 'required|string',
            'status_surat' => 'required|string',
            'no_surat' => 'required|string|unique:surat_masuk,no_surat',
            'lampiran' => 'nullable|string',
            'kategori' => 'required|exists:kategori,id',
        ]);

        // Cari data surat masuk berdasarkan ID
        $suratMasuk = SuratMasuk::find($id);

        if ($suratMasuk) {
            $suratMasuk->update($validated);

            return response()->json(['message' => 'Surat berhasil diupdate', 'data' => $suratMasuk]);
        } else {
            return response()->json(['message' => 'Surat tidak ditemukan'], 404);
        }
    }

    // Menghapus surat masuk berdasarkan ID
    public function destroy($id)
    {
        $suratMasuk = SuratMasuk::find($id);

        if ($suratMasuk) {
            $suratMasuk->delete();
            return response()->json(['message' => 'Surat berhasil dihapus']);
        } else {
            return response()->json(['message' => 'Surat tidak ditemukan'], 404);
        }
    }
}
