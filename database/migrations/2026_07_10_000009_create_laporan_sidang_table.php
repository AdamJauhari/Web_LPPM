<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLaporanSidangTable extends Migration
{
    public function up()
    {
        Schema::create('laporan_sidang', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('penelitian_id');
            $table->date('tanggal_sidang')->nullable();
            $table->string('berita_acara_file', 255)->nullable(); // Path file berita acara
            $table->text('hasil_sidang')->nullable();
            $table->timestamps();

            $table->foreign('penelitian_id')->references('id')->on('penelitian')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('laporan_sidang');
    }
}
