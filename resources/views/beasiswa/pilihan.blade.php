@extends('layouts.app')

@section('title', 'Pilihan Beasiswa')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <h1 class="text-4xl font-bold mb-2 text-center">Jenis Beasiswa & Persyaratan</h1>
    <p class="text-center text-gray-600 mb-8">Pilih beasiswa yang sesuai dengan prestasi dan IPK Anda</p>
    
    <!-- Info IPK Mahasiswa -->
    <div class="bg-gradient-to-r from-blue-50 to-purple-50 border-2 border-blue-400 p-6 mb-8 rounded-lg">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <span class="text-5xl mr-4">📊</span>
                <div>
                    <h3 class="text-2xl font-bold text-blue-800">IPK Anda Saat Ini</h3>
                    <p class="text-3xl font-bold text-blue-600 mt-1">{{ number_format($ipk, 2) }}</p>
                </div>
            </div>
            <div class="text-right">
                <p class="text-sm text-gray-600 mb-2">Eligible untuk:</p>
                <div class="flex flex-wrap gap-2 justify-end">
                    @foreach($jenisBeasiswa as $beasiswa)
                        @if($beasiswa['eligible'])
                            <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-semibold">
                                ✅ {{ $beasiswa['nama'] }}
                            </span>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Syarat Umum -->
    <div class="bg-blue-50 border-l-4 border-blue-500 p-6 mb-8 rounded">
        <h3 class="text-xl font-bold text-blue-800 mb-3">Syarat Umum Beasiswa</h3>
        <ul class="space-y-2 text-blue-900">
            <li class="flex items-start">
                <span class="mr-2">✓</span>
                <span><strong>IPK sesuai standar beasiswa</strong> - Setiap beasiswa punya standar berbeda</span>
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
        @foreach($jenisBeasiswa as $beasiswa)
        <!-- {{ $beasiswa['nama'] }} -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition {{ !$beasiswa['eligible'] ? 'opacity-60' : '' }}">
            <div class="bg-gradient-to-r 
                {{ str_contains($beasiswa['nama'], 'Akademik') ? 'from-blue-500 to-blue-600' : '' }}
                {{ str_contains($beasiswa['nama'], 'Non-Akademik') ? 'from-purple-500 to-purple-600' : '' }}
                {{ str_contains($beasiswa['nama'], 'Olahraga') ? 'from-orange-500 to-orange-600' : '' }}
                {{ str_contains($beasiswa['nama'], 'Seni') ? 'from-pink-500 to-pink-600' : '' }}
                p-6 text-white relative">
                
                <!-- Badge Status -->
                @if($beasiswa['eligible'])
                    <div class="absolute top-4 right-4 bg-green-500 text-white px-3 py-1 rounded-full text-xs font-bold">
                        ✅ ELIGIBLE
                    </div>
                @else
                    <div class="absolute top-4 right-4 bg-red-500 text-white px-3 py-1 rounded-full text-xs font-bold">
                        ❌ NOT ELIGIBLE
                    </div>
                @endif

                <div class="flex items-center justify-between mt-6">
                    <div>
                        <h3 class="text-2xl font-bold mb-2">
                            @if(str_contains($beasiswa['nama'], 'Akademik'))
                                📚
                            @elseif(str_contains($beasiswa['nama'], 'Non-Akademik'))
                                🌟
                            @elseif(str_contains($beasiswa['nama'], 'Olahraga'))
                                🏆
                            @else
                                🎨
                            @endif
                            {{ $beasiswa['nama'] }}
                        </h3>
                        <p class="text-white opacity-90">{{ $beasiswa['deskripsi'] }}</p>
                    </div>
                    <div class="text-6xl opacity-50">
                        @if(str_contains($beasiswa['nama'], 'Akademik'))
                            🎓
                        @elseif(str_contains($beasiswa['nama'], 'Non-Akademik'))
                            👥
                        @elseif(str_contains($beasiswa['nama'], 'Olahraga'))
                            ⚽
                        @else
                            🎭
                        @endif
                    </div>
                </div>
            </div>
            <div class="p-6">
                <!-- IPK Requirement -->
                <div class="mb-4 p-4 rounded-lg {{ $beasiswa['eligible'] ? 'bg-green-50 border-2 border-green-400' : 'bg-red-50 border-2 border-red-400' }}">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-semibold {{ $beasiswa['eligible'] ? 'text-green-800' : 'text-red-800' }}">
                                IPK Minimum Diperlukan
                            </p>
                            <p class="text-3xl font-bold {{ $beasiswa['eligible'] ? 'text-green-600' : 'text-red-600' }}">
                                {{ number_format($beasiswa['ipk_minimum'], 2) }}
                            </p>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-600">IPK Anda</p>
                            <p class="text-3xl font-bold {{ $beasiswa['eligible'] ? 'text-green-600' : 'text-red-600' }}">
                                {{ number_format($ipk, 2) }}
                            </p>
                        </div>
                    </div>
                    @if(!$beasiswa['eligible'])
                        <p class="text-sm text-red-600 mt-2 font-semibold">
                            Kurang {{ number_format($beasiswa['ipk_minimum'] - $ipk, 2) }} poin dari IPK minimum
                        </p>
                    @endif
                </div>

                <div class="mb-4">
                    <h4 class="font-bold text-lg mb-2 
                        {{ str_contains($beasiswa['nama'], 'Akademik') ? 'text-blue-600' : '' }}
                        {{ str_contains($beasiswa['nama'], 'Non-Akademik') ? 'text-purple-600' : '' }}
                        {{ str_contains($beasiswa['nama'], 'Olahraga') ? 'text-orange-600' : '' }}
                        {{ str_contains($beasiswa['nama'], 'Seni') ? 'text-pink-600' : '' }}">
                        Persyaratan Khusus:
                    </h4>
                    <ul class="space-y-2 text-gray-700">
                        <li class="flex items-start">
                            <span class="text-green-500 mr-2">●</span>
                            <span>IPK minimal <strong>{{ number_format($beasiswa['ipk_minimum'], 2) }}</strong></span>
                        </li>
                        @if(str_contains($beasiswa['nama'], 'Akademik'))
                            <li class="flex items-start">
                                <span class="text-green-500 mr-2">●</span>
                                <span>Transkrip nilai semester terakhir</span>
                            </li>
                            <li class="flex items-start">
                                <span class="text-green-500 mr-2">●</span>
                                <span>Surat rekomendasi dari dosen</span>
                            </li>
                        @elseif(str_contains($beasiswa['nama'], 'Non-Akademik'))
                            <li class="flex items-start">
                                <span class="text-green-500 mr-2">●</span>
                                <span>Aktif di organisasi kemahasiswaan</span>
                            </li>
                            <li class="flex items-start">
                                <span class="text-green-500 mr-2">●</span>
                                <span>Surat keterangan aktif organisasi</span>
                            </li>
                        @elseif(str_contains($beasiswa['nama'], 'Olahraga'))
                            <li class="flex items-start">
                                <span class="text-green-500 mr-2">●</span>
                                <span>Juara tingkat Provinsi/Nasional</span>
                            </li>
                            <li class="flex items-start">
                                <span class="text-green-500 mr-2">●</span>
                                <span>Sertifikat/piagam prestasi</span>
                            </li>
                        @else
                            <li class="flex items-start">
                                <span class="text-green-500 mr-2">●</span>
                                <span>Prestasi seni tingkat Provinsi/Nasional</span>
                            </li>
                            <li class="flex items-start">
                                <span class="text-green-500 mr-2">●</span>
                                <span>Portfolio karya seni</span>
                            </li>
                        @endif
                    </ul>
                </div>
                <div class="bg-green-50 p-4 rounded mb-4">
                    <p class="text-sm text-green-800">
                        <strong>Benefit:</strong> 
                        @if(str_contains($beasiswa['nama'], 'Akademik'))
                            Biaya kuliah penuh + Uang saku Rp 1.000.000/bulan
                        @elseif(str_contains($beasiswa['nama'], 'Non-Akademik'))
                            Potongan biaya kuliah 50% + Sertifikat
                        @elseif(str_contains($beasiswa['nama'], 'Olahraga'))
                            Biaya kuliah 75% + Dana pembinaan atlet
                        @else
                            Biaya kuliah 75% + Dana pengembangan seni
                        @endif
                    </p>
                </div>
                
                @if($beasiswa['eligible'])
                    <a href="{{ route('beasiswa.daftar') }}" 
                        class="block text-center bg-gradient-to-r 
                        {{ str_contains($beasiswa['nama'], 'Akademik') ? 'from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800' : '' }}
                        {{ str_contains($beasiswa['nama'], 'Non-Akademik') ? 'from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800' : '' }}
                        {{ str_contains($beasiswa['nama'], 'Olahraga') ? 'from-orange-600 to-orange-700 hover:from-orange-700 hover:to-orange-800' : '' }}
                        {{ str_contains($beasiswa['nama'], 'Seni') ? 'from-pink-600 to-pink-700 hover:from-pink-700 hover:to-pink-800' : '' }}
                        text-white px-6 py-3 rounded-lg font-semibold transition shadow-md hover:shadow-lg">
                        ✅ Daftar Sekarang
                    </a>
                @else
                    <button disabled
                        class="block w-full text-center bg-gray-400 text-white px-6 py-3 rounded-lg font-semibold cursor-not-allowed">
                        ❌ IPK Tidak Memenuhi Syarat
                    </button>
                @endif
            </div>
        </div>
        @endforeach
    </div>

    <!-- Call to Action -->
    <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg p-8 text-white text-center">
        <h2 class="text-3xl font-bold mb-4">Siap Mendaftar?</h2>
        <p class="text-xl mb-2">IPK Anda: <strong>{{ number_format($ipk, 2) }}</strong></p>
        <p class="text-lg mb-6">Jangan lewatkan kesempatan untuk mendapatkan beasiswa yang sesuai!</p>
        <a href="{{ route('beasiswa.daftar') }}" 
            class="inline-block bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition shadow-lg">
            Ke Halaman Pendaftaran →
        </a>
    </div>

    <!-- Info IPK Dinamis -->
    <div class="mt-8 bg-yellow-50 border border-yellow-400 rounded-lg p-6">
        <h3 class="font-bold text-yellow-800 mb-2">ℹ️ Informasi IPK</h3>
        <ul class="text-sm text-yellow-900 space-y-2">
            <li>• IPK Anda bersifat dinamis dan akan berubah setiap kali memulai sesi browsing baru</li>
            <li>• Setiap jenis beasiswa memiliki standar IPK minimum yang berbeda</li>
            <li>• Pastikan IPK Anda memenuhi syarat sebelum mendaftar</li>
        </ul>
    </div>
</div>
@endsection