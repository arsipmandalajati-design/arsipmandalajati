<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pejabat extends Model
{
    protected $fillable = [

        'nama_pejabat',
        'nip',
        'jabatan',
        'tanda_tangan'

    ];
}