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
    Schema::table('surat_masuks', function (Blueprint $table) {

        $table->string('jenis_surat')
              ->nullable()
              ->after('kode_arsip_id');


        $table->string('sumber_arsip')
              ->nullable()
              ->after('jenis_surat');


        $table->string('nomor_manual')
              ->nullable()
              ->after('nomor_surat');

    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('surat_masuks', function (Blueprint $table) {
            //
        });
    }
};
