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
        Schema::table('surat_masuks', function (Blueprint $table) {
    
            $table->string('tempat')->nullable();
    
            $table->date('tanggal_kegiatan')->nullable();
    
            $table->time('jam_mulai')->nullable();
    
            $table->time('jam_selesai')->nullable();
    
            $table->text('materi')->nullable();
    
        });
    }
    
    public function down(): void
    {
        Schema::table('surat_masuks', function (Blueprint $table) {
    
            $table->dropColumn([
                'tempat',
                'tanggal_kegiatan',
                'jam_mulai',
                'jam_selesai',
                'materi'
            ]);
    
        });
    }
};