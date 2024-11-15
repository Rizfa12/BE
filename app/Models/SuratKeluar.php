<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratKeluar extends Model
{
    use HasFactory;

    protected $table = 'surat_keluar';

    protected $fillable = [
        'pengirim',
        'penerima',
        'tanggal_kirim',
        'subject',
        'isi_surat',
        'status_surat',
        'lampiran',
        'no_surat',
        'kategori_id',
        'surat_masuk_id',
    ];

    protected $dates = [
        'tanggal_terima'
    ];

    public function suratMasuk()
    {
        return $this->belongsTo(SuratMasuk::class, 'surat_masuk_id');
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }
}
