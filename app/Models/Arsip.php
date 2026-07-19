<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Arsip extends Model
{
    protected $fillable = [
        'kode_arsip',
        'nama_arsip',
        'tanggal_arsip',
        'kategori',
        'file_arsip'
    ];
    
    public function kodearsip()
    {
        return $this->belongsTo(KodeArsip::class);
    }
}
