<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePkmSubmissionsTable extends Migration
{
    public function up()
    {
        Schema::create('pkm_submissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('fakultas', 10)->nullable();
            $table->string('semester', 10)->nullable();     // Ganjil / Genap
            $table->year('tahun')->nullable();
            $table->string('nama_dosen', 255)->nullable();  // snapshot
            $table->string('judul', 255);
            $table->text('abstrak');
            $table->string('sumber_dana', 20)->default('Internal');   // Internal / Eksternal
            $table->decimal('total_dana', 15, 0)->nullable();
            // Field khusus PKM
            $table->text('pelaksanaan')->nullable();                   // Deskripsi pelaksanaan
            $table->string('luaran_jurnal', 100)->nullable();         // Kategori jurnal yang ditarget
            $table->string('sumber_dana_eksternal', 255)->nullable(); // Jika dari sumber eksternal
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
        Schema::dropIfExists('pkm_submissions');
    }
}
