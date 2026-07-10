<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLaporanJurnalTable extends Migration
{
    public function up()
    {
        Schema::create('laporan_jurnal', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('penelitian_id');
            $table->enum('kategori_jurnal', [
                'Sinta 0', 'Sinta 1', 'Sinta 2', 'Sinta 3', 'Sinta 4', 'Sinta 5',
                'Non Sinta', 'Non Scopus', 'Scopus', 'Web of Science', 'Lainnya'
            ])->nullable();
            $table->string('nama_jurnal', 255)->nullable();
            $table->string('url_jurnal', 255)->nullable();
            $table->string('file_bukti', 255)->nullable(); // Path file bukti publikasi
            $table->timestamps();

            $table->foreign('penelitian_id')->references('id')->on('penelitian')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('laporan_jurnal');
    }
}
