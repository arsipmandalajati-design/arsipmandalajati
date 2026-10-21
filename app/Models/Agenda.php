<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    use HasFactory;

    protected $fillable = [

        'surat_masuk_id',
        'user_id',
        'nama_kegiatan',
        'tanggal',
        'jam_mulai',
        'jam_selesai',
        'tempat',
        'materi',
        'penyelenggara',
        'status',
        'keterangan',
    
        'hasil_kegiatan',
        'hasil_materi',
        'catatan',
        'dokumentasi',
    
        'kursi',
        'meja',
        'proyektor',
        'mic',
        'sound_system',
        'kabel_roll',
        'lainnya',
    
    ];

    public function suratMasuk()
    {
        return $this->belongsTo(SuratMasuk::class, 'surat_masuk_id');
    }


    public function user()
    {
        return $this->belongsTo(
            User::class,
            'user_id'
        );
    }
}