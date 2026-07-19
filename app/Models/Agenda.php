<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SuratMasuk;

class Agenda extends Model
{
    use HasFactory;

    protected $table = 'agendas';

    protected $fillable = [

        'user_id',
        'surat_masuk_id',

        'nama_kegiatan',
        'tanggal',
        'jam_mulai',
        'jam_selesai',
        'tempat',

        'penyelenggara',
        'materi',
        'keterangan',

        'hasil_kegiatan',
        'hasil_materi',
        'dokumentasi',
        'catatan',

        'jumlah_peserta',

        'kursi',
        'meja',
        'proyektor',
        'mic',
        'sound_system',
        'kabel_roll',
        'lainnya',

        'status',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function suratMasuk()
    {
        return $this->belongsTo(
            SuratMasuk::class,
            'surat_masuk_id'
        );
    }

    public function user()
    {
        return $this->belongsTo(
            User::class,
            'user_id'
        );
    }
}