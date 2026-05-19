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
        Schema::create('customer', function (Blueprint $table) {
            $table->string('idcustomer', 100)->primary();

            $table->string('nama', 255);
            $table->char('id_provinsi', 2)->nullable();
            $table->char('id_kota', 4)->nullable();
            $table->char('id_kecamatan', 6)->nullable();
            $table->char('id_kelurahan', 10)->nullable();

            $table->text('alamat')->nullable();
            $table->longText('foto_blob')->nullable();
            $table->string('foto_path')->nullable();

            $table->timestamps();

            $table->foreign('id_provinsi')->references('id')->on('reg_provinces')->onDelete('set null');
            $table->foreign('id_kota')->references('id')->on('reg_regencies')->onDelete('set null');
            $table->foreign('id_kecamatan')->references('id')->on('reg_districts')->onDelete('set null');
            $table->foreign('id_kelurahan')->references('id')->on('reg_villages')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer');
    }
};
