<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengajuanProposalTable extends Migration
{
    public function up()
    {
        Schema::create('pengajuan_proposal', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('penelitian_id');
            $table->unsignedBigInteger('user_id');
            $table->text('catatan_pengajuan')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamp('tanggal_ajuan')->nullable();
            $table->timestamps();

            $table->foreign('penelitian_id')->references('id')->on('penelitian')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pengajuan_proposal');
    }
}
