@extends('layouts.app')

@section('title', 'Home - Sistem Beasiswa')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 rounded-lg shadow-xl p-12 text-white mb-8">
        <h1 class="text-5xl font-bold mb-4">Selamat Datang di Sistem Beasiswa</h1>
        <p class="text-xl mb-6">Platform pendaftaran beasiswa online untuk mahasiswa berprestasi</p>
        <div class="flex space-x-4">
            <a href="{{ route('beasiswa.daftar') }}" 
                class="inline-block bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition">
                Daftar Sekarang
            </a>
            <a href="{{ route('beasiswa.pilihan') }}" 
                class="inline-block bg-blue-500 text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-400 transition">
                Lihat Pilihan Beasiswa
            </a>
        </div>
    </div>

    <!-- Info IPK -->
    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-6 mb-8 rounded">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <span class="text-4xl">📊</span>
            </div>
            <div class="ml-4">
                <h3 class="text-lg font-bold text-yellow-800">Informasi IPK Anda</h3>
                <p class="text-yellow-700">
                    IPK Anda saat ini: <strong class="text-2xl">{{ App\Http\Controllers\BeasiswaController::getIpk() }}</strong>
                </p>
                @if(App\Http\Controllers\BeasiswaController::getIpk() >= 3.0)
                    <p class="text-green-600 font-semibold mt-2">✅ Selamat! Anda memenuhi syarat untuk mendaftar beasiswa</p>
                @else
                    <p class="text-red-600 font-semibold mt-2">❌ Maaf, IPK Anda belum memenuhi syarat (minimal 3.0)</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Features -->
    <div class="grid md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition">
            <div class="text-5xl mb-4">📚</div>
            <h3 class="text-xl font-bold mb-2">Beasiswa Akademik</h3>
            <p class="text-gray-600 mb-4">Untuk mahasiswa dengan prestasi akademik tinggi</p>
            <a href="{{ route('beasiswa.pilihan') }}" class="text-blue-600 hover:text-blue-800 font-semibold">
                Lihat Detail →
            </a>
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition">
            <div class="text-5xl mb-4">🏆</div>
            <h3 class="text-xl font-bold mb-2">Beasiswa Prestasi</h3>
            <p class="text-gray-600 mb-4">Untuk mahasiswa berprestasi di bidang olahraga dan seni</p>
            <a href="{{ route('beasiswa.pilihan') }}" class="text-blue-600 hover:text-blue-800 font-semibold">
                Lihat Detail →
            </a>
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition">
            <div class="text-5xl mb-4">🌟</div>
            <h3 class="text-xl font-bold mb-2">Beasiswa Non-Akademik</h3>
            <p class="text-gray-600 mb-4">Untuk mahasiswa aktif organisasi</p>
            <a href="{{ route('beasiswa.pilihan') }}" class="text-blue-600 hover:text-blue-800 font-semibold">
                Lihat Detail →
            </a>
        </div>
    </div>

    <!-- Prosedur Pendaftaran -->
    <div class="bg-white rounded-lg shadow-lg p-8">
        <h2 class="text-3xl font-bold mb-6 text-center">Prosedur Pendaftaran</h2>
        <div class="grid md:grid-cols-4 gap-6">
            <div class="text-center">
                <div class="bg-blue-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                    <span class="text-2xl font-bold text-blue-600">1</span>
                </div>
                <h4 class="font-bold mb-2">Cek IPK</h4>
                <p class="text-sm text-gray-600">Pastikan IPK Anda minimal 3.0</p>
            </div>
            
            <div class="text-center">
                <div class="bg-blue-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                    <span class="text-2xl font-bold text-blue-600">2</span>
                </div>
                <h4 class="font-bold mb-2">Pilih Beasiswa</h4>
                <p class="text-sm text-gray-600">Pilih jenis beasiswa yang sesuai</p>
            </div>
            
            <div class="text-center">
                <div class="bg-blue-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                    <span class="text-2xl font-bold text-blue-600">3</span>
                </div>
                <h4 class="font-bold mb-2">Upload Berkas</h4>
                <p class="text-sm text-gray-600">Upload dokumen persyaratan</p>
            </div>
            
            <div class="text-center">
                <div class="bg-blue-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                    <span class="text-2xl font-bold text-blue-600">4</span>
                </div>
                <h4 class="font-bold mb-2">Submit</h4>
                <p class="text-sm text-gray-600">Kirim pendaftaran dan tunggu verifikasi</p>
            </div>
        </div>
    </div>
</div>
@endsection