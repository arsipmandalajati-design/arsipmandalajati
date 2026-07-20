<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\KodeArsip;
use App\Models\Pejabat;
use App\Models\Agenda;

class SuratMasuk extends Model
{
    protected $fillable = [

        'user_id',
        'kode_arsip_id',
        'nomor_surat',
        'jenis_surat',
        'sumber_arsip',
    
'nomor_urut',
'nomor_registrasi',

        'judul',
        'pengirim',
        'tanggal_surat',
        'perihal',
        'file_surat',
    
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
        'lainnya',
    
        'status',
        'user_disposisi_id',
    
        'catatan_admin',   // TAMBAHKAN
    ];

    /*
    |--------------------------------------------------------------------------
    | Relasi Kode Arsip
    |--------------------------------------------------------------------------
    */

    public function kodearsip()
    {
        return $this->belongsTo(
            KodeArsip::class,
            'kode_arsip_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Relasi Pejabat
    |--------------------------------------------------------------------------
    */

    public function pejabat()
{
    return $this->belongsTo(Pejabat::class, 'pejabat_id');
}

    /*
    |--------------------------------------------------------------------------
    | Pegawai Pembuat Surat
    |--------------------------------------------------------------------------
    */

    public function user()
    {
        return $this->belongsTo(
            User::class,
            'user_id'
        );
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
    | Agenda
    |--------------------------------------------------------------------------
    */

    public function agenda()
{
    return $this->hasOne(Agenda::class,'surat_masuk_id');
}


}