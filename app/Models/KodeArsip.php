<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KodeArsip extends Model
{
    use HasFactory;

    protected $table = 'kode_arsips';

    protected $fillable = [

        'kode',

        'nama_arsip',

        'keterangan',

    ];

    /*
    |--------------------------------------------------------------------------
    | RELASI KE DATA ARSIP
    |--------------------------------------------------------------------------
    */

    public function arsips()
    {
        return $this->hasMany(
            Arsip::class,
            'kode_arsip_id'
        );
    }
}