<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
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

    public function down(): void
    {
        Schema::table('surat_masuks', function (Blueprint $table) {

            $table->dropForeign(['pejabat_id']);

            $table->dropColumn([
                'status',
                'pejabat_id',
                'catatan_admin'
            ]);

        });
    }
};