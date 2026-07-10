<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenelitianTable extends Migration
{
    public function up()
    {
        Schema::create('penelitian', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dosen_id')->nullable();
            $table->integer('universitas_id')->nullable();
            $table->enum('klasifikasi', ['Internasional', 'Nasional (Dikti/Saintek)', 'Nasional (Kemenag)', 'Internal', 'Mitra'])->nullable();
            $table->year('tahun')->nullable();
            $table->decimal('dana', 15, 0)->nullable();
            $table->decimal('jumlah_dana', 15, 0)->nullable();
            $table->string('judul', 255);
            $table->enum('status_proposal', ['pending', 'approved', 'rejected'])->default('pending');
            $table->enum('status_verifikasi', ['pending', 'verified', 'rejected'])->default('pending');
            $table->timestamps();

            $table->foreign('dosen_id')->references('id')->on('dosen')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('penelitian');
    }
}
