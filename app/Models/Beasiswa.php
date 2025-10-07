<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model Beasiswa
 * 
 * Model untuk mengelola data pendaftaran beasiswa mahasiswa
 * 
 * @author Your Name
 * @version 1.0
 * @date 2025-10-06
 * 
 * Initial State: Data mahasiswa yang mendaftar beasiswa
 * Final State: Data tersimpan dengan status ajuan "Belum diverifikasi"
 */
class Beasiswa extends Model
{
    use HasFactory;

    /**
     * Nama tabel di database
     */
    protected $table = 'beasiswa';

    /**
     * Kolom yang bisa diisi secara mass assignment
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama',
        'email',
        'nomor_hp',
        'semester',
        'ipk',
        'pilihan_beasiswa',
        'berkas',
        'status_ajuan',
    ];

    /**
     * Tipe data casting untuk atribut tertentu
     *
     * @var array<string, string>
     */
    protected $casts = [
        'ipk' => 'decimal:2',
        'semester' => 'integer',
    ];

    /**
     * Accessor untuk format IPK
     * Mengembalikan IPK dengan format 2 desimal
     */
    public function getFormattedIpkAttribute(): string
    {
            return number_format((float) $this->ipk, 2, ',', '.');

    }

    /**
     * Scope untuk filter berdasarkan status ajuan
     */
    public function scopeBelumDiverifikasi($query)
    {
        return $query->where('status_ajuan', 'Belum diverifikasi');
    }

    /**
     * Scope untuk filter berdasarkan jenis beasiswa
     */
    public function scopeByJenisBeasiswa($query, $jenis)
    {
        return $query->where('pilihan_beasiswa', $jenis);
    }

    /**
     * Cek apakah mahasiswa eligible untuk beasiswa (IPK >= 3.0)
     */
    public static function isEligible($ipk): bool
    {
        return $ipk >= 3.0;
    }
}