<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class SuratKeluar extends Model
{
    use HasFactory;

    protected $table = 'surat_keluars';

    protected $fillable = [
        'user_id',
        'kode_arsip_id',
        'nomor_surat',
        'judul',
        'pengirim',
        'tujuan',
        'tanggal_surat',
        'perihal',
        'disposisi',
        'file_surat'
    ];

    /**
     * Casting tipe data otomatis
     */
    protected $casts = [
        'tanggal_surat' => 'date',
    ];

    /**
     * Appends untuk menyertakan atribut buatan saat dipanggil via API/JSON Modal Preview
     */
    protected $appends = [
        'file_url',
        'status_badge'
    ];

    /*
    |--------------------------------------------------------------------------
    | RELASI DATABASE
    |--------------------------------------------------------------------------
    */

    /**
     * Relasi ke tabel Kode Arsip
     */
    public function kodearsip()
    {
        return $this->belongsTo(KodeArsip::class, 'kode_arsip_id');
    }

    /**
     * Relasi ke tabel User (Admin/Pegawai yang membuat/menginput surat)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSOR & HELPER ATTRIBUTES
    |--------------------------------------------------------------------------
    */

    /**
     * Mendapatkan Full URL File PDF untuk Preview
     */
    public function getFileUrlAttribute()
    {
        if ($this->file_surat && Storage::disk('public')->exists($this->file_surat)) {
            return asset('storage/' . $this->file_surat);
        }
        return null;
    }

    /**
     * Helper Badge Warna Status Disposisi untuk UI Bootstrap/Tailwind
     */
    public function getStatusBadgeAttribute()
    {
        return match (strtolower($this->disposisi ?? '')) {
            'disetujui', 'acc' => 'badge-success',
            'ditolak'          => 'badge-danger',
            default            => 'badge-warning', // Menunggu ACC / Pending
        };
    }
}