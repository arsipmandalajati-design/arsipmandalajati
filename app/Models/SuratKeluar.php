<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratKeluar extends Model
{
    use HasFactory;

    protected $fillable = [

        'user_id',

        'kode_arsip_id',

        'nomor_surat',

        'judul',

        'pengirim',

        'tujuan',

        'tanggal_surat',

        'perihal',

        'file_surat'

    ];

    public function kodearsip()
    {
        return $this->belongsTo(KodeArsip::class,
            'kode_arsip_id');
    }
}