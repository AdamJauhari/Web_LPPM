<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDosenTable extends Migration
{
    public function up()
    {
        Schema::create('dosen', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('nama_dosen', 100);
            $table->string('nidn', 20)->nullable();
            $table->string('nupk', 20)->nullable();
            $table->string('pangkat_jabatan', 100)->nullable();
            $table->unsignedBigInteger('id_prodi')->nullable();
            $table->text('dosen_luaran')->nullable(); // daftar luaran/karya
            $table->string('no_hp', 20)->nullable();
            $table->string('sk_dosen', 255)->nullable(); // path/nomor SK
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('id_prodi')->references('id')->on('prodi')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('dosen');
    }
}
