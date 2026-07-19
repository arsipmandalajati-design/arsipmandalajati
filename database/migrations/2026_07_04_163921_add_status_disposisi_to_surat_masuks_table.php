<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Cek dulu apakah kolom 'status' belum ada di tabel 'surat_masuks'
        if (!Schema::hasColumn('surat_masuks', 'status')) {
            Schema::table('surat_masuks', function (Blueprint $table) {

                $table->enum('status',[
                    'Menunggu',
                    'Sudah Dibaca',
                    'Sudah Disposisi',
                    'Sudah Dijadikan Agenda',
                    'Selesai'
                ])->default('Menunggu');

                $table->unsignedBigInteger('user_disposisi')->nullable();

                $table->foreign('user_disposisi')
                      ->references('id')
                      ->on('users')
                      ->nullOnDelete();
                      
                $table->unsignedBigInteger('pejabat_id')
                      ->nullable()
                      ->after('status');

                $table->text('catatan_admin')
                      ->nullable()
                      ->after('pejabat_id');

                $table->foreign('pejabat_id')
                      ->references('id')
                      ->on('pejabats')
                      ->nullOnDelete();

            });
        }
    }

    public function down(): void
    {
        Schema::table('surat_masuks', function (Blueprint $table) {
            // Kita juga amankan proses drop foreign key-nya
            if (Schema::hasColumn('surat_masuks', 'pejabat_id')) {
                $table->dropForeign(['pejabat_id']);
            }
            if (Schema::hasColumn('surat_masuks', 'user_disposisi')) {
                $table->dropForeign(['user_disposisi']);
            }

            $table->dropColumn([
                'status',
                'user_disposisi',
                'pejabat_id',
                'catatan_admin'
            ]);
        });
    }
};