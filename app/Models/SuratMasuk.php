<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratMasuk extends Model
{
    use HasFactory;

    protected $table = 'surat_masuks'; // Sesuaikan dengan nama tabel surat masuk di database Anda

    // Kolom-kolom yang diizinkan untuk mass assignment
    protected $fillable = [
        'user_id',
        'user_disposisi_id',
        'kode_arsip_id',
        'nomor_urut',
        'nomor_registrasi',
        'jenis_surat',
        'sumber_arsip',
        'nomor_surat',
        'judul',
        'pengirim',
        'tanggal_surat',
        'perihal',
        'file_surat',
        'status',
        'catatan_admin',
        // Kolom opsional booking/logistik jika diisi
        'tempat',
        'tanggal_kegiatan',
        'jam_mulai',
        'jam_selesai',
        'materi',
        'jumlah_peserta',
        'kursi',
        'meja',
        'proyektor',
        'mic',
        'sound_system',
        'kabel_roll',
        'lainnya'
    ];

    /**
     * Relasi ke Kode Arsip
     */
    public function kodearsip()
    {
        return $this->belongsTo(KodeArsip::class, 'kode_arsip_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Pegawai Pembuat/Penginput Surat
    |--------------------------------------------------------------------------
    */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Pegawai Tujuan Disposisi
    |--------------------------------------------------------------------------
    */
    public function userDisposisi()
    {
        return $this->belongsTo(User::class, 'user_disposisi_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Relasi Agenda (Logistik Internal)
    |--------------------------------------------------------------------------
    */
    public function agenda()
    {
        return $this->hasOne(Agenda::class, 'surat_masuk_id');
    }
}