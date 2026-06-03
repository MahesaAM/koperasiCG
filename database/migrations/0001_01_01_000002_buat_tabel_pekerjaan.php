<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pekerjaan', function (Blueprint $table) {
            $table->id();
            $table->string('antrean')->index();
            $table->longText('muatan');
            $table->unsignedTinyInteger('percobaan');
            $table->unsignedInteger('dipesan_pada')->nullable();
            $table->unsignedInteger('tersedia_pada');
            $table->unsignedInteger('dibuat_pada');
        });

        Schema::create('batch_pekerjaan', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('nama');
            $table->integer('total_pekerjaan');
            $table->integer('pekerjaan_menunggu');
            $table->integer('pekerjaan_gagal');
            $table->longText('id_pekerjaan_gagal');
            $table->mediumText('opsi')->nullable();
            $table->integer('dibatalkan_pada')->nullable();
            $table->integer('dibuat_pada');
            $table->integer('selesai_pada')->nullable();
        });

        Schema::create('pekerjaan_gagal', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->text('koneksi');
            $table->text('antrean');
            $table->longText('muatan');
            $table->longText('pengecualian');
            $table->timestamp('gagal_pada')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pekerjaan');
        Schema::dropIfExists('batch_pekerjaan');
        Schema::dropIfExists('pekerjaan_gagal');
    }
};
