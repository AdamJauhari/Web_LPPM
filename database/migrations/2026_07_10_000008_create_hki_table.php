<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHkiTable extends Migration
{
    public function up()
    {
        Schema::create('hki', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('penelitian_id');
            $table->enum('jenis_hki', ['Paten', 'HAKI', 'Hak Cipta', 'Merek', 'Desain Industri', 'Desain Tata Letak'])->default('Hak Cipta');
            $table->string('judul_hki', 255);
            $table->string('nomor_pendaftaran', 100)->nullable(); // Nomor dari DJKI
            $table->string('file_sertifikat', 255)->nullable(); // Path file sertifikat
            $table->timestamps();

            $table->foreign('penelitian_id')->references('id')->on('penelitian')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('hki');
    }
}
