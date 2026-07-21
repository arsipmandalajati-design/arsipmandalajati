<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratKeluar extends Model
{
    use HasFactory;

    protected $table = 'surat_keluars'; // Sesuaikan jika nama tabel Anda berbeda (opsional)

    protected $fillable = [
        'user_id',
        'kode_arsip_id',
        'nomor_surat',
        'judul',
        'pengirim',
        'tujuan',
        'tanggal_surat',
        'perihal',
        'disposisi', // Ditambahkan agar kolom disposisi bisa disimpan (mass assignable)
        'file_surat'
    ];

    /**
     * Relasi ke tabel Kode Arsip
     */
    public function kodearsip()
    {
        return $this->belongsTo(KodeArsip::class, 'kode_arsip_id');
    }

    /**
     * Relasi ke tabel User (Admin/Pegawai yang menginput surat)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}