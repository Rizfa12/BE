<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratMasuk extends Model
{
    protected $table = 'surat_masuk';

    protected $fillable = [
        'pengirim',
        'penerima',
        'tanggal_terima',
        'subject',
        'isi_surat',
        'status_surat',
        'lampiran',
        'no_surat',
        'kategori_id',
    ];

    protected $dates = [
        'tanggal_terima'
    ];

    public function suratKeluar()
    {
        return $this->hasMany(SuratKeluar::class, 'surat_masuk_id');
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }
}
