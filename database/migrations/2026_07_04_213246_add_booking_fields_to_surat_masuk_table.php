<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Dikosongkan karena kolom-kolom booking sudah dibuat oleh file migrasi bertanggal 4 Juli.
        // Ini menghindari konflik duplikasi skema pada database produksi di Railway.
    }

    public function down(): void
    {
        // Dikosongkan untuk keamanan rollback
    }
};