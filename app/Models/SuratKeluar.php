<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratKeluar extends Model
{
    use HasFactory;

    // Nama tabel di database (jika nama tabel Anda bentuk plural standar Laravel, baris ini opsional)
    protected $table = 'surat_keluars';

    // Kolom yang diizinkan untuk diisi secara massal (Mass Assignment)
    protected $fillable = [
        'user_id',
        'kode_arsip_id',
        'nomor_manual',
        'nomor_surat',
        'tanggal_surat',
        'tujuan',
        'judul',
        'perihal',
        'file_surat',
        'disposisi', // <-- Tambahkan ini
    ];

    /*
    |--------------------------------------------------------------------------
    | RELASI USER PEMBUAT
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
    | RELASI USER DISPOSISI
    |--------------------------------------------------------------------------
    */

    public function userDisposisi()
    {
        return $this->belongsTo(
            User::class,
            'user_disposisi_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | RELASI KODE ARSIP
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
    | ACCESSOR STATUS BADGE
    |--------------------------------------------------------------------------
    */

    public function getStatusBadgeAttribute()
    {

        switch ($this->status) {

            case 'Belum ACC':
                return 'secondary';

            case 'Belum Disposisi':
                return 'warning';

            case 'Sudah Disposisi':
                return 'success';

            default:
                return 'primary';
        }

    }

    public function tujuanUser()
{
    return $this->belongsTo(User::class, 'tujuan'); 
}
}