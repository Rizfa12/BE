<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\SuratKeluar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SuratKeluarController extends Controller
{
    public function index()
    {
        $suratKeluar = SuratKeluar::with('kategori')->get();
        return response()->json($suratKeluar);
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pengirim' => 'required|string|max:255',
            'penerima' => 'required|string|max:255',
            'tanggal_kirim' => 'required|date',
            'subject' => 'required|string|max:255',
            'isi_surat' => 'required|string',
            'status_surat' => 'required|string',
            'lampiran' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
            'kategori_id' => 'required|exists:kategori,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $validated = $validator->validated();

            // Handle file upload for attachment
            if ($request->hasFile('lampiran')) {
                $filePath = $request->file('lampiran')->store('lampiran', 'public');
                $validated['lampiran'] = $filePath;
            }

            // Fetch the last surat and increment its unique number
            $lastSurat = SuratKeluar::orderBy('id', 'desc')->first();
            $newNumber = str_pad($lastSurat ? $lastSurat->id + 1 : 1, 3, '0', STR_PAD_LEFT);

            // Get the abbreviation and code from category
            $kategori = Kategori::find($request->kategori_id);

            $categoryCode = $kategori ? str_pad($kategori->id, 2, '0', STR_PAD_LEFT) : '00';
            $categoryAbbreviation = $kategori ? $kategori->singkatan : 'UNK';

            error_log("categoryCode: " . $categoryCode);
            error_log("categoryAbbreviation: " . $categoryAbbreviation);
            // e.g., 'SU'

            // Sender abbreviation (pengirim)
            $senderAbbreviation = strtoupper($request->input('singkatan_penerima') ?? 'XX');

            // Get the date
            $date = new \DateTime($request->tanggal_kirim);
            $romanMonths = ["I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII"];
            $monthInRoman = $romanMonths[$date->format('n') - 1];
            $year = $date->format('Y');

            // Format no_surat as "01.001/SU/DP/X/2024"
            $no_surat = "{$categoryCode}.{$newNumber}/{$categoryAbbreviation}/{$senderAbbreviation}/{$monthInRoman}/{$year}";

            // Save the surat with the generated no_surat
            $suratKeluar = SuratKeluar::create(array_merge($validated, ['no_surat' => $no_surat]));

            return response()->json([
                'message' => 'Surat berhasil ditambah',
                'data' => $suratKeluar
            ], 201);
        } catch (\Exception $e) {
            \Log::error('Error in store function: ' . $e->getMessage());
            return response()->json([
                'message' => 'Terjadi kesalahan saat menambah surat',
                'error' => $e->getMessage()
            ], 500);
        }
    }




    public function show($id)
    {
        $suratKeluar = SuratKeluar::find($id);

        if ($suratKeluar) {
            return response()->json($suratKeluar, 200);
        } else {
            return response()->json(['message' => 'Surat tidak ditemukan'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'pengirim' => 'required|string|max:255',
            'penerima' => 'required|string|max:255',
            'tanggal_kirim' => 'required|date',
            'subject' => 'required|string|max:255',
            'isi_surat' => 'required|string',
            'status_surat' => 'required|string',
            'no_surat' => 'required|string|unique:surat_keluar,no_surat,' . $id,
            'lampiran' => 'nullable|string',
            'kategori' => 'required|exists:kategori,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $suratKeluar = SuratKeluar::find($id);

        if ($suratKeluar) {
            try {
                $suratKeluar->update($validator->validated());
                return response()->json([
                    'message' => 'Surat berhasil diupdate',
                    'data' => $suratKeluar
                ], 200);
            } catch (\Exception $e) {
                return response()->json([
                    'message' => 'Terjadi kesalahan saat mengupdate surat',
                    'error' => $e->getMessage()
                ], 500);
            }
        } else {
            return response()->json(['message' => 'Surat tidak ditemukan'], 404);
        }
    }

    public function destroy($id)
    {
        $suratKeluar = SuratKeluar::find($id);

        if ($suratKeluar) {
            try {
                $suratKeluar->delete();
                return response()->json(['message' => 'Surat berhasil dihapus'], 200);
            } catch (\Exception $e) {
                return response()->json([
                    ' message' => 'Terjadi kesalahan saat menghapus surat',
                    'error' => $e->getMessage()
                ], 500);
            }
        } else {
            return response()->json(['message' => 'Surat tidak ditemukan'], 404);
        }
    }
}
