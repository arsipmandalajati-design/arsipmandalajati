<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Arsip extends Model
{
    use HasFactory;

    protected $table = 'arsips';

    // Tambahkan 'nomor_registrasi' di sini
    protected $fillable = [

        'kode_arsip',
        'nomor_registrasi',
        'nama_arsip',
        'tanggal_arsip',
        'kategori',
        'file_arsip',
    
        'retensi_tahun',
        'tanggal_kadaluarsa',
    
    ];

    
    /**
     * Relasi ke KodeArsip berdasarkan kolom 'kode_arsip' yang mencocokkan kolom 'kode' di tabel kode_arsips
     */
    public function kodearsip()
    {
        return $this->belongsTo(KodeArsip::class, 'kode_arsip', 'kode');
    }
}