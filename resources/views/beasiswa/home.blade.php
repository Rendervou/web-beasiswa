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
    <div class="bg-gradient-to-r from-yellow-50 to-orange-50 border-2 border-yellow-400 p-6 mb-8 rounded-lg">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <span class="text-5xl mr-4">📊</span>
                <div>
                    <h3 class="text-lg font-bold text-yellow-800">IPK Anda Saat Ini</h3>
                    <p class="text-4xl font-bold text-yellow-600 mt-1">
                        {{ number_format($ipk, 2) }}
                    </p>
                    <p class="text-sm text-gray-600 mt-2">
                        <em>IPK berubah setiap sesi browsing baru</em>
                    </p>
                </div>
            </div>
            <div class="text-right">
                <div class="mb-4">
                    <p class="text-sm font-semibold text-gray-700 mb-2">Status Kelayakan:</p>
                    @php
                        $eligibleCount = 0;
                        foreach($standarIpk as $jenis => $minIpk) {
                            if($ipk >= $minIpk) $eligibleCount++;
                        }
                    @endphp
                    @if($eligibleCount > 0)
                        <div class="bg-green-100 border-2 border-green-500 rounded-lg p-4">
                            <p class="text-green-800 font-bold text-lg">✅ ELIGIBLE</p>
                            <p class="text-green-700 text-sm">
                                Anda memenuhi syarat untuk <strong>{{ $eligibleCount }}</strong> jenis beasiswa
                            </p>
                        </div>
                    @else
                        <div class="bg-red-100 border-2 border-red-500 rounded-lg p-4">
                            <p class="text-red-800 font-bold text-lg">❌ NOT ELIGIBLE</p>
                            <p class="text-red-700 text-sm">IPK belum memenuhi syarat</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Detail Standar IPK -->
        <div class="mt-4 pt-4 border-t-2 border-yellow-300">
            <h4 class="font-bold text-yellow-800 mb-3">Standar IPK Per Beasiswa:</h4>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                @foreach($standarIpk as $jenis => $minIpk)
                    <div class="bg-white rounded-lg p-3 border-2 {{ $ipk >= $minIpk ? 'border-green-400' : 'border-gray-300' }}">
                        <p class="font-bold text-sm {{ $ipk >= $minIpk ? 'text-green-700' : 'text-gray-500' }}">
                            {{ $jenis }}
                        </p>
                        <p class="text-xs text-gray-600">Min: {{ number_format($minIpk, 2) }}</p>
                        <p class="text-lg font-bold {{ $ipk >= $minIpk ? 'text-green-600' : 'text-red-600' }}">
                            {{ $ipk >= $minIpk ? '✅' : '❌' }}
                        </p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Features -->
    <div class="grid md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition">
            <div class="text-5xl mb-4">📚</div>
            <h3 class="text-xl font-bold mb-2">Beasiswa Akademik</h3>
            <p class="text-gray-600 mb-2">Untuk mahasiswa dengan prestasi akademik tinggi</p>
            <div class="my-3 p-3 bg-blue-50 rounded">
                <p class="text-sm font-semibold text-blue-800">
                    IPK Minimum: {{ number_format($standarIpk['Akademik'], 2) }}
                </p>
                <p class="text-xs text-blue-600 mt-1">
                    Status: {{ $ipk >= $standarIpk['Akademik'] ? '✅ Eligible' : '❌ Belum Eligible' }}
                </p>
            </div>
            <a href="{{ route('beasiswa.pilihan') }}" class="text-blue-600 hover:text-blue-800 font-semibold">
                Lihat Detail →
            </a>
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition">
            <div class="text-5xl mb-4">🏆</div>
            <h3 class="text-xl font-bold mb-2">Beasiswa Prestasi</h3>
            <p class="text-gray-600 mb-2">Untuk mahasiswa berprestasi di bidang olahraga dan seni</p>
            <div class="my-3 p-3 bg-orange-50 rounded">
                <p class="text-sm font-semibold text-orange-800">
                    IPK Minimum: {{ number_format($standarIpk['Prestasi Olahraga'], 2) }}
                </p>
                <p class="text-xs text-orange-600 mt-1">
                    Status: {{ $ipk >= $standarIpk['Prestasi Olahraga'] ? '✅ Eligible' : '❌ Belum Eligible' }}
                </p>
            </div>
            <a href="{{ route('beasiswa.pilihan') }}" class="text-blue-600 hover:text-blue-800 font-semibold">
                Lihat Detail →
            </a>
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition">
            <div class="text-5xl mb-4">🌟</div>
            <h3 class="text-xl font-bold mb-2">Beasiswa Non-Akademik</h3>
            <p class="text-gray-600 mb-2">Untuk mahasiswa aktif organisasi</p>
            <div class="my-3 p-3 bg-purple-50 rounded">
                <p class="text-sm font-semibold text-purple-800">
                    IPK Minimum: {{ number_format($standarIpk['Non-Akademik'], 2) }}
                </p>
                <p class="text-xs text-purple-600 mt-1">
                    Status: {{ $ipk >= $standarIpk['Non-Akademik'] ? '✅ Eligible' : '❌ Belum Eligible' }}
                </p>
            </div>
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
                <p class="text-sm text-gray-600">Pastikan IPK Anda sesuai standar beasiswa yang dipilih</p>
            </div>
            
            <div class="text-center">
                <div class="bg-blue-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                    <span class="text-2xl font-bold text-blue-600">2</span>
                </div>
                <h4 class="font-bold mb-2">Pilih Beasiswa</h4>
                <p class="text-sm text-gray-600">Pilih jenis beasiswa yang sesuai dengan IPK Anda</p>
            </div>
            
            <div class="text-center">
                <div class="bg-blue-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                    <span class="text-2xl font-bold text-blue-600">3</span>
                </div>
                <h4 class="font-bold mb-2">Upload Berkas</h4>
                <p class="text-sm text-gray-600">Upload dokumen persyaratan lengkap</p>
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

    <!-- Info IPK Dinamis -->
    <div class="mt-8 bg-blue-50 border border-blue-400 rounded-lg p-6">
        <h3 class="font-bold text-blue-800 mb-2">ℹ️ Tentang IPK Dinamis</h3>
        <ul class="text-sm text-blue-900 space-y-2">
            <li>• <strong>IPK Anda berubah otomatis</strong> setiap kali Anda memulai sesi browsing baru (refresh browser atau tutup/buka tab)</li>
            <li>• IPK berkisar antara <strong>2.50 - 4.00</strong> untuk simulasi berbagai kondisi mahasiswa</li>
            <li>• <strong>Setiap beasiswa</strong> memiliki standar IPK minimum yang berbeda</li>
            <li>• Gunakan fitur ini untuk melihat beasiswa mana yang sesuai dengan berbagai tingkat IPK</li>
        </ul>
    </div>
</div>
@endsection