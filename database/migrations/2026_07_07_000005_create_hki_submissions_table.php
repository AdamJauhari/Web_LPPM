<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHkiSubmissionsTable extends Migration
{
    public function up()
    {
        Schema::create('hki_submissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('fakultas', 10)->nullable();
            $table->string('judul', 255);
            $table->text('abstrak');
            $table->enum('jenis_hki', ['Paten', 'HAKI', 'Non-Scopus / Hak Cipta Lainnya']);
            $table->year('tahun_pengajuan')->nullable();
            $table->date('tanggal_pengajuan')->nullable();
            $table->string('nomor_pendaftaran', 100)->nullable();  // Dari DJKI
            $table->string('team_members', 500)->nullable();
            // Workflow
            $table->enum('status', ['pending', 'assigned', 'under_review', 'approved', 'rejected'])->default('pending');
            $table->text('admin_notes')->nullable();
            $table->unsignedBigInteger('assigned_to')->nullable();
            $table->unsignedBigInteger('reviewed_by')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('assigned_to')->references('id')->on('users')->onDelete('set null');
            $table->foreign('reviewed_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('hki_submissions');
    }
}
