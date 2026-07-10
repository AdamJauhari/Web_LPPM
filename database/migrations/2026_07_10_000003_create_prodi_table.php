<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProdiTable extends Migration
{
    public function up()
    {
        Schema::create('prodi', function (Blueprint $table) {
            $table->id();
            $table->string('nama_prodi', 100);
            $table->string('nama_koordinator', 100)->nullable();
            $table->text('dosen')->nullable(); // daftar dosen (bisa JSON atau teks)
            $table->unsignedBigInteger('fakultas_id')->nullable();
            $table->string('no_hp', 20)->nullable();
            $table->string('email', 100)->nullable();
            $table->timestamps();

            $table->foreign('fakultas_id')->references('id')->on('fakultas')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('prodi');
    }
}
