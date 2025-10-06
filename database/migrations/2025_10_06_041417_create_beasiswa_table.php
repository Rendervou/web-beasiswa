<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration untuk tabel beasiswa
 * Menyimpan data pendaftaran beasiswa mahasiswa
 * 
 * @author Your Name
 * @version 1.0
 * @date 2025-10-06
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('beasiswa', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 100);
            $table->string('email', 100)->unique();
            $table->string('nomor_hp', 15);
            $table->integer('semester');
            $table->decimal('ipk', 3, 2);
            $table->enum('pilihan_beasiswa', ['Akademik', 'Non-Akademik', 'Prestasi Olahraga', 'Prestasi Seni']);
            $table->string('berkas', 255)->nullable();
            $table->enum('status_ajuan', ['Belum diverifikasi', 'Sedang diverifikasi', 'Diterima', 'Ditolak'])
                  ->default('Belum diverifikasi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beasiswa');
    }
};