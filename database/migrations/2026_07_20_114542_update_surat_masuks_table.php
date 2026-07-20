<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    // Cek dulu, kalau kolom 'user_id' BELUM ADA, baru ditambahkan
    if (!Schema::hasColumn('surat_masuks', 'user_id')) {
        Schema::table('surat_masuks', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->after('id')->constrained('users')->onDelete('cascade');
        });
    }
}
public function down()
{
    if (Schema::hasColumn('surat_masuks', 'user_id')) {
        Schema::table('surat_masuks', function (Blueprint $table) {
            $table->dropForeign(['user_id']); // jika memakai foreign key
            $table->dropColumn('user_id');
        });
    }
}
};