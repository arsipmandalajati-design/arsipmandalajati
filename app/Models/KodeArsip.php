<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\SuratMasuk;
use App\Models\SuratKeluar;

class KodeArsip extends Model
{
    protected $table = 'kode_arsips';

    protected $fillable = [
        'kode',
        'nama_arsip'
    ];

    public function suratMasuk()
{
    return $this->hasMany(SuratMasuk::class, 'kode_arsip_id');
}

public function suratKeluar()
{
    return $this->hasMany(SuratKeluar::class, 'kode_arsip_id');
}
}