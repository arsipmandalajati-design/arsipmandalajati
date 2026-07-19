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
    Schema::table('agendas', function (Blueprint $table) {

        $table->text('kebutuhan')->nullable()->after('materi');

        $table->string('status_wa')
              ->default('Belum Dikirim')
              ->after('kebutuhan');

        $table->string('penanggung_jawab')
              ->nullable()
              ->after('status_wa');

    });
}

public function down()
{
    Schema::table('agendas', function (Blueprint $table) {

        $table->dropColumn([
            'kebutuhan',
            'status_wa',
            'penanggung_jawab'
        ]);

    });
}
};
