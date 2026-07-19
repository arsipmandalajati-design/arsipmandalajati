<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('surat_masuks', function (Blueprint $table) {
            if (Schema::hasColumn('surat_masuks', 'catatan_admin')) {
                // Jika sudah ada, ubah menjadi nullable
                $table->text('catatan_admin')->nullable()->change();
            } else {
                // Jika belum ada (kasus error Railway sekarang), buat baru setelah pejabat_id
                $table->text('catatan_admin')->nullable()->after('pejabat_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('surat_masuks', function (Blueprint $table) {
            // Kembalikan ke kondisi sebelumnya jika diperlukan
            if (Schema::hasColumn('surat_masuks', 'catatan_admin')) {
                $table->text('catatan_admin')->nullable(false)->change();
            }
        });
    }
};