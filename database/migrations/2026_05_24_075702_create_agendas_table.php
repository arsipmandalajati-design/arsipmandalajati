<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('agendas', function (Blueprint $table) {

            $table->id();

            $table->string('nama_kegiatan');

            $table->date('tanggal');

            $table->text('hasil_kegiatan')->nullable();

            $table->text('hasil_materi')->nullable();

            $table->string('dokumentasi')->nullable();

            $table->text('catatan')->nullable();

            $table->time('jam_mulai');
            
            $table->time('jam_selesai');

            $table->string('tempat');

            $table->string('penyelenggara');

            $table->text('keterangan')->nullable();

            $table->string('lampiran')->nullable();

            $table->enum('status',[
                'Terjadwal',
                'Selesai',
                'Ditunda'
            ])->default('Terjadwal');

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agendas');
    }
};