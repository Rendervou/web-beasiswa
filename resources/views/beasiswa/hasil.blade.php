@extends('layouts.app')

@section('title', 'Hasil Pendaftaran')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <h1 class="text-4xl font-bold mb-2 text-center">Hasil Pendaftaran Beasiswa</h1>
    <p class="text-center text-gray-600 mb-8">Daftar semua mahasiswa yang telah mendaftar beasiswa</p>
    
    @if($daftarBeasiswa->isEmpty())
        <!-- Jika belum ada pendaftaran -->
        <div class="bg-white rounded-lg shadow-lg p-12 text-center">
            <div class="text-6xl mb-4">📋</div>
            <h2 class="text-2xl font-bold mb-2 text-gray-800">Belum Ada Pendaftaran</h2>
            <p class="text-gray-600 mb-6">Jadilah yang pertama mendaftar beasiswa!</p>
            <a href="{{ route('beasiswa.daftar') }}" 
                class="inline-block bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
                Daftar Beasiswa Sekarang
            </a>
        </div>
    @else
        <!-- Info Standar IPK -->
        <div class="bg-gradient-to-r from-blue-50 to-purple-50 border-2 border-blue-400 p-6 mb-8 rounded-lg">
            <h3 class="text-lg font-bold text-blue-800 mb-3">📊 Standar IPK Minimum per Beasiswa:</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach($standarIpk as $jenis => $minIpk)
                    <div class="bg-white rounded-lg p-4 shadow-md">
                        <p class="font-bold text-sm text-gray-700">{{ $jenis }}</p>
                        <p class="text-2xl font-bold text-blue-600">{{ number_format($minIpk, 2) }}</p>
                        <p class="text-xs text-gray-500">IPK Minimum</p>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Statistik -->
        <div class="grid md:grid-cols-4 gap-6 mb-8">
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-lg p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm opacity-90 mb-1">Total Pendaftar</p>
                        <p class="text-4xl font-bold">{{ $daftarBeasiswa->count() }}</p>
                    </div>
                    <div class="text-5xl opacity-80">👥</div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-lg shadow-lg p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm opacity-90 mb-1">Belum Diverifikasi</p>
                        <p class="text-4xl font-bold">{{ $daftarBeasiswa->where('status_ajuan', 'Belum diverifikasi')->count() }}</p>
                    </div>
                    <div class="text-5xl opacity-80">⏳</div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-lg shadow-lg p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm opacity-90 mb-1">IPK Tertinggi</p>
                        <p class="text-4xl font-bold">{{ number_format($daftarBeasiswa->max('ipk'), 2) }}</p>
                    </div>
                    <div class="text-5xl opacity-80">📊</div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg shadow-lg p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm opacity-90 mb-1">IPK Terendah</p>
                        <p class="text-4xl font-bold">{{ number_format($daftarBeasiswa->min('ipk'), 2) }}</p>
                    </div>
                    <div class="text-5xl opacity-80">📉</div>
                </div>
            </div>
        </div>

        <!-- Tabel Hasil Pendaftaran -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-8">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-blue-600">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-medium text-white uppercase">No</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-white uppercase">Nama</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-white uppercase">Email</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-white uppercase">No. HP</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-white uppercase">Semester</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-white uppercase">IPK</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-white uppercase">Beasiswa</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-white uppercase">Status IPK</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-white uppercase">Berkas</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-white uppercase">Status Ajuan</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-white uppercase">Tanggal Daftar</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($daftarBeasiswa as $index => $beasiswa)
                        @php
                            $minIpkRequired = $standarIpk[$beasiswa->pilihan_beasiswa] ?? 3.0;
                            $ipkMemenuhi = $beasiswa->ipk >= $minIpkRequired;
                        @endphp
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $index + 1 }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                {{ $beasiswa->nama }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $beasiswa->email }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $beasiswa->nomor_hp }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-xs font-semibold">
                                    Semester {{ $beasiswa->semester }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-center">
                                <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full">
                                    {{ number_format($beasiswa->ipk, 2) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <div class="flex flex-col">
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold mb-1
                                        {{ $beasiswa->pilihan_beasiswa == 'Akademik' ? 'bg-blue-100 text-blue-800' : '' }}
                                        {{ $beasiswa->pilihan_beasiswa == 'Non-Akademik' ? 'bg-purple-100 text-purple-800' : '' }}
                                        {{ $beasiswa->pilihan_beasiswa == 'Prestasi Olahraga' ? 'bg-orange-100 text-orange-800' : '' }}
                                        {{ $beasiswa->pilihan_beasiswa == 'Prestasi Seni' ? 'bg-pink-100 text-pink-800' : '' }}">
                                        {{ $beasiswa->pilihan_beasiswa }}
                                    </span>
                                    <span class="text-xs text-gray-500">
                                        Min: {{ number_format($minIpkRequired, 2) }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                @if($ipkMemenuhi)
                                    <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-semibold">
                                        ✅ Memenuhi
                                    </span>
                                @else
                                    <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-xs font-semibold">
                                        ❌ Kurang {{ number_format($minIpkRequired - $beasiswa->ipk, 2) }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @if($beasiswa->berkas)
                                    <a href="{{ route('beasiswa.download', $beasiswa->id) }}" 
                                        class="text-blue-600 hover:text-blue-800 font-semibold inline-flex items-center">
                                        <span class="mr-1">📎</span> Download
                                    </a>
                                @else
                                    <span class="text-gray-400">Tidak ada</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold
                                    {{ $beasiswa->status_ajuan == 'Belum diverifikasi' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $beasiswa->status_ajuan == 'Sedang diverifikasi' ? 'bg-blue-100 text-blue-800' : '' }}
                                    {{ $beasiswa->status_ajuan == 'Diterima' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $beasiswa->status_ajuan == 'Ditolak' ? 'bg-red-100 text-red-800' : '' }}">
                                    {{ $beasiswa->status_ajuan }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $beasiswa->created_at->format('d/m/Y H:i') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Statistik Beasiswa -->
        <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
            <h2 class="text-2xl font-bold mb-6">Statistik Per Jenis Beasiswa</h2>
            <div class="grid md:grid-cols-4 gap-6">
                @foreach($standarIpk as $jenis => $minIpk)
                @php
                    $beasiswaJenis = $daftarBeasiswa->where('pilihan_beasiswa', $jenis);
                    $jumlah = $beasiswaJenis->count();
                    $avgIpk = $jumlah > 0 ? $beasiswaJenis->avg('ipk') : 0;
                    $memenuhi = $beasiswaJenis->filter(function($b) use ($minIpk) {
                        return $b->ipk >= $minIpk;
                    })->count();
                @endphp
                <!-- {{ $jenis }} -->
                <div class="border-2 rounded-lg p-6 hover:shadow-lg transition
                    {{ $jenis == 'Akademik' ? 'border-blue-200' : '' }}
                    {{ $jenis == 'Non-Akademik' ? 'border-purple-200' : '' }}
                    {{ $jenis == 'Prestasi Olahraga' ? 'border-orange-200' : '' }}
                    {{ $jenis == 'Prestasi Seni' ? 'border-pink-200' : '' }}">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-bold
                            {{ $jenis == 'Akademik' ? 'text-blue-600' : '' }}
                            {{ $jenis == 'Non-Akademik' ? 'text-purple-600' : '' }}
                            {{ $jenis == 'Prestasi Olahraga' ? 'text-orange-600' : '' }}
                            {{ $jenis == 'Prestasi Seni' ? 'text-pink-600' : '' }}">
                            {{ $jenis }}
                        </h3>
                        <span class="text-3xl">
                            {{ $jenis == 'Akademik' ? '📚' : '' }}
                            {{ $jenis == 'Non-Akademik' ? '🌟' : '' }}
                            {{ $jenis == 'Prestasi Olahraga' ? '🏆' : '' }}
                            {{ $jenis == 'Prestasi Seni' ? '🎨' : '' }}
                        </span>
                    </div>
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Jumlah:</span>
                            <span class="font-bold">{{ $jumlah }} orang</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">IPK Min Required:</span>
                            <span class="font-bold text-blue-600">{{ number_format($minIpk, 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">IPK Rata-rata:</span>
                            <span class="font-bold {{ $avgIpk >= $minIpk ? 'text-green-600' : 'text-red-600' }}">
                                {{ number_format($avgIpk, 2) }}
                            </span>
                        </div>
                        <div class="flex justify-between pt-2 border-t">
                            <span class="text-gray-600">Memenuhi Syarat:</span>
                            <span class="font-bold text-green-600">{{ $memenuhi }}/{{ $jumlah }}</span>
                        </div>
                        @if($jumlah > 0)
                        <div class="mt-2">
                            <div class="bg-gray-200 rounded-full h-2">
                                <div class="bg-green-500 rounded-full h-2" 
                                    style="width: {{ ($memenuhi / $jumlah) * 100 }}%">
                                </div>
                            </div>
                            <p class="text-xs text-gray-500 mt-1 text-center">
                                {{ number_format(($memenuhi / $jumlah) * 100, 1) }}% memenuhi syarat
                            </p>
                        </div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-center space-x-4">
            <a href="{{ route('beasiswa.daftar') }}" 
                class="bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-700 transition inline-flex items-center">
                <span class="mr-2">➕</span>
                Tambah Pendaftaran Baru
            </a>
            <a href="{{ route('beasiswa.home') }}" 
                class="bg-gray-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-gray-700 transition inline-flex items-center">
                <span class="mr-2">🏠</span>
                Kembali ke Home
            </a>
        </div>
    @endif
</div>
@endsection