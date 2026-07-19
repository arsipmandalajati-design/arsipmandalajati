<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Cek dulu apakah kolom 'kursi' belum ada di tabel 'agendas'
        if (!Schema::hasColumn('agendas', 'kursi')) {
            Schema::table('agendas', function (Blueprint $table) {
        
                $table->integer('kursi')->default(0);
        
                $table->integer('meja')->default(0);
        
                $table->integer('proyektor')->default(0);
        
                $table->integer('mic')->default(0);
        
                $table->integer('sound_system')->default(0);
        
                $table->integer('kabel_roll')->default(0);
        
                $table->text('lainnya')->nullable();
        
            });
        }
    }
    
    public function down()
    {
        Schema::table('agendas', function (Blueprint $table) {
            $table->dropColumn([
                'kursi',
                'meja',
                'proyektor',
                'mic',
                'sound_system',
                'kabel_roll',
                'lainnya'
            ]);
        });
    }
};