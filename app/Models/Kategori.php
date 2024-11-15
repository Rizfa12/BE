<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategori';

    protected $fillable = [
        'nama',
        'singkatan',
    ];

    protected $hidden = [
        'singkatan',
    ];

    public function suratMasuk()
    {
        return $this->hasMany(SuratMasuk::class, 'kategori');
    }

    public function suratKeluar()
    {
        return $this->hasMany(SuratKeluar::class, 'kategori');
    }
}
