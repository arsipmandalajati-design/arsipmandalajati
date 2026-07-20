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
        // Cek dulu apakah tabel ada dan kolom 'status' belum ada di tabel 'surat_masuks'
        if (Schema::hasTable('surat_masuks') && !Schema::hasColumn('surat_masuks', 'status')) {
            Schema::table('surat_masuks', function (Blueprint $table) {

                // 1. Kolom Status Utama Pelacakan
                $table->enum('status', [
                    'Menunggu',
                    'Sudah Dibaca',
                    'Sudah Disposisi',
                    'Sudah Dijadikan Agenda',
                    'Selesai'
                ])->default('Menunggu')->after('file_surat');

                // 2. Kolom User Penerima Disposisi (Disamakan dengan nama di Model: user_disposisi_id)
                $table->unsignedBigInteger('user_disposisi_id')->nullable()->after('status');
                $table->foreign('user_disposisi_id')
                      ->references('id')
                      ->on('users')
                      ->nullOnDelete();
                      
                // 3. Kolom Pejabat Terkait
                $table->unsignedBigInteger('pejabat_id')->nullable()->after('user_disposisi_id');
                $table->foreign('pejabat_id')
                      ->references('id')
                      ->on('pejabats')
                      ->nullOnDelete();

                // 4. Catatan/Instruksi Disposisi dari Admin/Superadmin
                $table->text('catatan_admin')->nullable()->after('pejabat_id');

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
                
                // Hapus foreign key terlebih dahulu jika kolomnya memang ada
                if (Schema::hasColumn('surat_masuks', 'pejabat_id')) {
                    $table->dropForeign(['pejabat_id']);
                }
                if (Schema::hasColumn('surat_masuks', 'user_disposisi_id')) {
                    $table->dropForeign(['user_disposisi_id']);
                }

                // Kumpulkan kolom-kolom yang ingin dihapus jika ada di database
                $columnsToDrop = [];
                foreach (['status', 'user_disposisi_id', 'pejabat_id', 'catatan_admin'] as $col) {
                    if (Schema::hasColumn('surat_masuks', $col)) {
                        $columnsToDrop[] = $col;
                    }
                }

                // Eksekusi drop jika ada kolom yang terdeteksi
                if (!empty($columnsToDrop)) {
                    $table->dropColumn($columnsToDrop);
                }
            });
        }
    }
};