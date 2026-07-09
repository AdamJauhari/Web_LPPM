<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ExpandResearchSubmissionsTable extends Migration
{
    public function up()
    {
        Schema::table('research_submissions', function (Blueprint $table) {
            $table->string('fakultas', 10)->nullable()->after('user_id');
            $table->string('semester', 10)->nullable()->after('fakultas');   // Ganjil / Genap
            $table->year('tahun')->nullable()->after('semester');
            $table->string('nama_dosen', 255)->nullable()->after('tahun');   // snapshot
            $table->string('sumber_dana', 20)->nullable()->after('abstract'); // Internal / Eksternal
            $table->decimal('total_dana', 15, 0)->nullable()->after('sumber_dana');
            $table->string('kategori_luaran', 100)->nullable()->after('total_dana');
            // Workflow
            $table->unsignedBigInteger('assigned_to')->nullable()->after('admin_notes');
            $table->unsignedBigInteger('reviewed_by')->nullable()->after('assigned_to');
            $table->timestamp('reviewed_at')->nullable()->after('reviewed_by');
            $table->text('rejection_reason')->nullable()->after('reviewed_at');

            $table->foreign('assigned_to')->references('id')->on('users')->onDelete('set null');
            $table->foreign('reviewed_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('research_submissions', function (Blueprint $table) {
            $table->dropForeign(['assigned_to', 'reviewed_by']);
            $table->dropColumn([
                'fakultas', 'semester', 'tahun', 'nama_dosen',
                'sumber_dana', 'total_dana', 'kategori_luaran',
                'assigned_to', 'reviewed_by', 'reviewed_at', 'rejection_reason',
            ]);
        });
    }
}
