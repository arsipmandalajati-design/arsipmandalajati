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
        if (!Schema::hasColumn('arsips', 'tanggal_kadaluarsa')) {
            Schema::table('arsips', function (Blueprint $table) {
                $table->date('tanggal_kadaluarsa')->nullable()->after('tanggal_arsip');
            });
        }
    }

public function down(): void
{
    Schema::table('arsips', function (Blueprint $table) {

        $table->dropColumn('tanggal_kadaluarsa');

    });
}
};
