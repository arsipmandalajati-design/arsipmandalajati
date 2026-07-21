<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratKeluar extends Model
{
    use HasFactory;

    protected $table = 'surat_keluars';

    protected $fillable = [

        'user_id',

        'kode_arsip_id',

        'nomor_urut',

        'nomor_registrasi',

        'nomor_surat',

        'judul',

        'pengirim',

        'tujuan',

        'tanggal_surat',

        'perihal',

        'file_surat',

        'status',

        'user_disposisi_id',

        'catatan_admin',

    ];

    protected $casts = [

        'tanggal_surat' => 'date',

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

}