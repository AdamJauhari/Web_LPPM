<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDosenFieldsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Kolom identitas dosen
            $table->string('nidn', 20)->nullable()->after('nim_nip');
            $table->string('fakultas', 100)->nullable()->after('nidn');
            $table->string('jabatan_fungsional', 100)->nullable()->after('fakultas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['nidn', 'fakultas', 'jabatan_fungsional']);
        });
    }
}
