<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBeritaTable extends Migration
{
    public function up()
    {
        Schema::create('berita', function (Blueprint $table) {
            $table->id();
            $table->string('judul', 255);
            $table->string('slug', 255)->unique();
            $table->text('ringkasan')->nullable();      // ringkasan singkat
            $table->longText('konten');                 // isi berita lengkap
            $table->string('gambar', 255)->nullable();  // path gambar
            $table->string('kategori', 50)->default('Umum'); // Umum, Penelitian, Pengabdian, Akademik
            $table->enum('status', ['draft', 'published'])->default('published');
            $table->date('tanggal');
            $table->string('penulis', 100)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('berita');
    }
}
