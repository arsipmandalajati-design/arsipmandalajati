<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('surat_masuks')) {
            Schema::table('surat_masuks', function (Blueprint $table) {

                // Mengelompokkan logistik tepat di bawah kolom materi (dari migrasi sebelumnya)
                if (!Schema::hasColumn('surat_masuks', 'jumlah_peserta')) {
                    $table->integer('jumlah_peserta')->default(0)->after('materi');
                }

                if (!Schema::hasColumn('surat_masuks', 'kursi')) {
                    $table->integer('kursi')->default(0)->after('jumlah_peserta');
                }

                if (!Schema::hasColumn('surat_masuks', 'meja')) {
                    $table->integer('meja')->default(0)->after('kursi');
                }

                if (!Schema::hasColumn('surat_masuks', 'proyektor')) {
                    $table->integer('proyektor')->default(0)->after('meja');
                }

                if (!Schema::hasColumn('surat_masuks', 'mic')) {
                    $table->integer('mic')->default(0)->after('proyektor');
                }

                if (!Schema::hasColumn('surat_masuks', 'sound_system')) {
                    $table->integer('sound_system')->default(0)->after('mic');
                }

                if (!Schema::hasColumn('surat_masuks', 'kabel_roll')) {
                    $table->integer('kabel_roll')->default(0)->after('sound_system');
                }

                if (!Schema::hasColumn('surat_masuks', 'lainnya')) {
                    $table->string('lainnya')->nullable()->after('kabel_roll');
                }

            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('surat_masuks')) {
            Schema::table('surat_masuks', function (Blueprint $table) {

                // List kolom logistik yang ingin diperiksa keberadaannya
                $logistikColumns = [
                    'jumlah_peserta', 'kursi', 'meja', 'proyektor', 
                    'mic', 'sound_system', 'kabel_roll', 'lainnya'
                ];

                // Hanya kumpulkan kolom yang benar-benar ada di database untuk di-drop
                $columnsToDrop = [];
                foreach ($logistikColumns as $col) {
                    if (Schema::hasColumn('surat_masuks', $col)) {
                        $columnsToDrop[] = $col;
                    }
                }

                // Jalankan perintah drop jika array tidak kosong
                if (!empty($columnsToDrop)) {
                    $table->dropColumn($columnsToDrop);
                }

            });
        }
    }
};