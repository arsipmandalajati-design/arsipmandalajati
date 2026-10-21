<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pejabat extends Model
{
    use HasFactory;

    protected $table = 'pejabats'; // Sesuaikan jika nama tabel di DB kamu 'pejabats' (ganti jadi 'pejabats')

    protected $fillable = [
        'user_id',
        'nip',
        'jabatan',
        'golongan',
        'unit_kerja',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}