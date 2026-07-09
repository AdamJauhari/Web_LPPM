<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSintaFieldsToPublikasisTable extends Migration
{
    public function up()
    {
        Schema::table('publikasis', function (Blueprint $table) {
            $table->year('tahun_publikasi')->nullable()->after('kategori_reputasi');
            $table->string('nama_jurnal', 255)->nullable()->after('tahun_publikasi');
            $table->string('volume_edisi', 100)->nullable()->after('nama_jurnal');
            $table->string('doi', 255)->nullable()->after('volume_edisi');
            $table->string('sinta_id', 100)->nullable()->after('doi');
            $table->string('scopus_id', 100)->nullable()->after('sinta_id');
            $table->string('garuda_id', 100)->nullable()->after('scopus_id');
            // Sumber data: manual atau dari API
            $table->enum('sumber', ['manual', 'sinta_api', 'scopus_api', 'garuda_api'])->default('manual')->after('garuda_id');
            // Status verifikasi oleh admin
            $table->enum('status_verifikasi', ['pending', 'verified', 'rejected'])->default('pending')->after('sumber');
            $table->text('catatan_admin')->nullable()->after('status_verifikasi');
            $table->unsignedBigInteger('verified_by')->nullable()->after('catatan_admin');
            $table->timestamp('verified_at')->nullable()->after('verified_by');

            $table->foreign('verified_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('publikasis', function (Blueprint $table) {
            $table->dropForeign(['verified_by']);
            $table->dropColumn([
                'tahun_publikasi', 'nama_jurnal', 'volume_edisi', 'doi',
                'sinta_id', 'scopus_id', 'garuda_id', 'sumber',
                'status_verifikasi', 'catatan_admin', 'verified_by', 'verified_at',
            ]);
        });
    }
}
