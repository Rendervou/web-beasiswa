@extends('layouts.app')

@section('title', 'Pilihan Beasiswa')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <h1 class="text-4xl font-bold mb-2 text-center">Jenis Beasiswa & Persyaratan</h1>
    <p class="text-center text-gray-600 mb-8">Pilih beasiswa yang sesuai dengan prestasi dan minat Anda</p>
    
    <!-- Syarat Umum -->
    <div class="bg-blue-50 border-l-4 border-blue-500 p-6 mb-8 rounded">
        <h3 class="text-xl font-bold text-blue-800 mb-3">Syarat Umum Beasiswa</h3>
        <ul class="space-y-2 text-blue-900">
            <li class="flex items-start">
                <span class="mr-2">✓</span>
                <span><strong>IPK Minimal 3.0</strong> - Wajib untuk semua jenis beasiswa</span>
            </li>
            <li class="flex items-start">
                <span class="mr-2">✓</span>
                <span><strong>Mahasiswa Aktif</strong> - Semester 1-8</span>
            </li>
            <li class="flex items-start">
                <span class="mr-2">✓</span>
                <span><strong>Upload Berkas</strong> - Format PDF/JPG/ZIP maksimal 2MB</span>
            </li>
            <li class="flex items-start">
                <span class="mr-2">✓</span>
                <span><strong>Email Aktif</strong> - Untuk notifikasi hasil verifikasi</span>
            </li>
        </ul>
    </div>

    <!-- Grid Beasiswa -->
    <div class="grid md:grid-cols-2 gap-8 mb-8">
        <!-- Beasiswa Akademik -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition">
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-2xl font-bold mb-2">📚 Beasiswa Akademik</h3>
                        <p class="text-blue-100">Untuk mahasiswa berprestasi akademik</p>
                    </div>
                    <div class="text-6xl opacity-50">🎓</div>
                </div>
            </div>
            <div class="p-6">
                <div class="mb-4">
                    <h4 class="font-bold text-lg mb-2 text-blue-600">Persyaratan Khusus:</h4>
                    <ul class="space-y-2 text-gray-700">
                        <li class="flex items-start">
                            <span class="text-green-500 mr-2">●</span>
                            <span>IPK minimal <strong>3.0</strong></span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-green-500 mr-2">●</span>
                            <span>Transkrip nilai semester terakhir</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-green-500 mr-2">●</span>
                            <span>Surat rekomendasi dari dosen</span>
                        </li>
                    </ul>
                </div>
                <div class="bg-green-50 p-4 rounded mb-4">
                    <p class="text-sm text-green-800"><strong>Benefit:</strong> Biaya kuliah penuh + Uang saku Rp 1.000.000/bulan</p>
                </div>
                <a href="{{ route('beasiswa.daftar') }}" 
                    class="block text-center bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
                    Daftar Sekarang
                </a>
            </div>
        </div>

        <!-- Beasiswa Non-Akademik -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition">
            <div class="bg-gradient-to-r from-purple-500 to-purple-600 p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-2xl font-bold mb-2">🌟 Beasiswa Non-Akademik</h3>
                        <p class="text-purple-100">Untuk mahasiswa aktif organisasi</p>
                    </div>
                    <div class="text-6xl opacity-50">👥</div>
                </div>
            </div>
            <div class="p-6">
                <div class="mb-4">
                    <h4 class="font-bold text-lg mb-2 text-purple-600">Persyaratan Khusus:</h4>
                    <ul class="space-y-2 text-gray-700">
                        <li class="flex items-start">
                            <span class="text-green-500 mr-2">●</span>
                            <span>IPK minimal <strong>3.0</strong></span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-green-500 mr-2">●</span>
                            <span>Aktif di organisasi kemahasiswaan</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-green-500 mr-2">●</span>
                            <span>Surat keterangan aktif organisasi</span>
                        </li>
                    </ul>
                </div>
                <div class="bg-green-50 p-4 rounded mb-4">
                    <p class="text-sm text-green-800"><strong>Benefit:</strong> Potongan biaya kuliah 50% + Sertifikat</p>
                </div>
                <a href="{{ route('beasiswa.daftar') }}" 
                    class="block text-center bg-purple-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-purple-700 transition">
                    Daftar Sekarang
                </a>
            </div>
        </div>

        <!-- Beasiswa Prestasi Olahraga -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition">
            <div class="bg-gradient-to-r from-orange-500 to-orange-600 p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-2xl font-bold mb-2">🏆 Beasiswa Prestasi Olahraga</h3>
                        <p class="text-orange-100">Untuk atlet berprestasi</p>
                    </div>
                    <div class="text-6xl opacity-50">⚽</div>
                </div>
            </div>
            <div class="p-6">
                <div class="mb-4">
                    <h4 class="font-bold text-lg mb-2 text-orange-600">Persyaratan Khusus:</h4>
                    <ul class="space-y-2 text-gray-700">
                        <li class="flex items-start">
                            <span class="text-green-500 mr-2">●</span>
                            <span>IPK minimal <strong>3.0</strong></span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-green-500 mr-2">●</span>
                            <span>Juara tingkat Provinsi/Nasional</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-green-500 mr-2">●</span>
                            <span>Sertifikat/piagam prestasi</span>
                        </li>
                    </ul>
                </div>
                <div class="bg-green-50 p-4 rounded mb-4">
                    <p class="text-sm text-green-800"><strong>Benefit:</strong> Biaya kuliah 75% + Dana pembinaan atlet</p>
                </div>
                <a href="{{ route('beasiswa.daftar') }}" 
                    class="block text-center bg-orange-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-orange-700 transition">
                    Daftar Sekarang
                </a>
            </div>
        </div>

        <!-- Beasiswa Prestasi Seni -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition">
            <div class="bg-gradient-to-r from-pink-500 to-pink-600 p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-2xl font-bold mb-2">🎨 Beasiswa Prestasi Seni</h3>
                        <p class="text-pink-100">Untuk seniman muda berbakat</p>
                    </div>
                    <div class="text-6xl opacity-50">🎭</div>
                </div>
            </div>
            <div class="p-6">
                <div class="mb-4">
                    <h4 class="font-bold text-lg mb-2 text-pink-600">Persyaratan Khusus:</h4>
                    <ul class="space-y-2 text-gray-700">
                        <li class="flex items-start">
                            <span class="text-green-500 mr-2">●</span>
                            <span>IPK minimal <strong>3.0</strong></span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-green-500 mr-2">●</span>
                            <span>Prestasi seni tingkat Provinsi/Nasional</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-green-500 mr-2">●</span>
                            <span>Portfolio karya seni</span>
                        </li>
                    </ul>
                </div>
                <div class="bg-green-50 p-4 rounded mb-4">
                    <p class="text-sm text-green-800"><strong>Benefit:</strong> Biaya kuliah 75% + Dana pengembangan seni</p>
                </div>
                <a href="{{ route('beasiswa.daftar') }}" 
                    class="block text-center bg-pink-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-pink-700 transition">
                    Daftar Sekarang
                </a>
            </div>
        </div>
    </div>

    <!-- Call to Action -->
    <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg p-8 text-white text-center">
        <h2 class="text-3xl font-bold mb-4">Siap Mendaftar?</h2>
        <p class="text-xl mb-6">Jangan lewatkan kesempatan emas untuk mendapatkan beasiswa!</p>
        <a href="{{ route('beasiswa.daftar') }}" 
            class="inline-block bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition">
            Daftar Beasiswa Sekarang
        </a>
    </div>
</div>
@endsection