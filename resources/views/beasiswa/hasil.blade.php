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
                        <p class="text-sm opacity-90 mb-1">Beasiswa Akademik</p>
                        <p class="text-4xl font-bold">{{ $daftarBeasiswa->where('pilihan_beasiswa', 'Akademik')->count() }}</p>
                    </div>
                    <div class="text-5xl opacity-80">📚</div>
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
                            <th class="px-6 py-4 text-left text-xs font-medium text-white uppercase">Berkas</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-white uppercase">Status Ajuan</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-white uppercase">Tanggal Daftar</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($daftarBeasiswa as $index => $beasiswa)
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
                                <span class="px-3 py-1 rounded-full text-xs font-semibold
                                    {{ $beasiswa->pilihan_beasiswa == 'Akademik' ? 'bg-blue-100 text-blue-800' : '' }}
                                    {{ $beasiswa->pilihan_beasiswa == 'Non-Akademik' ? 'bg-purple-100 text-purple-800' : '' }}
                                    {{ $beasiswa->pilihan_beasiswa == 'Prestasi Olahraga' ? 'bg-orange-100 text-orange-800' : '' }}
                                    {{ $beasiswa->pilihan_beasiswa == 'Prestasi Seni' ? 'bg-pink-100 text-pink-800' : '' }}">
                                    {{ $beasiswa->pilihan_beasiswa }}
                                </span>
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
                <!-- Akademik -->
                <div class="border-2 border-blue-200 rounded-lg p-6 hover:shadow-lg transition">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-bold text-blue-600">Akademik</h3>
                        <span class="text-3xl">📚</span>
                    </div>
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Jumlah:</span>
                            <span class="font-bold">{{ $daftarBeasiswa->where('pilihan_beasiswa', 'Akademik')->count() }} orang</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">IPK Rata-rata:</span>
                            <span class="font-bold text-blue-600">
                                {{ $daftarBeasiswa->where('pilihan_beasiswa', 'Akademik')->count() > 0 
                                    ? number_format($daftarBeasiswa->where('pilihan_beasiswa', 'Akademik')->avg('ipk'), 2) 
                                    : '0.00' }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Non-Akademik -->
                <div class="border-2 border-purple-200 rounded-lg p-6 hover:shadow-lg transition">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-bold text-purple-600">Non-Akademik</h3>
                        <span class="text-3xl">🌟</span>
                    </div>
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Jumlah:</span>
                            <span class="font-bold">{{ $daftarBeasiswa->where('pilihan_beasiswa', 'Non-Akademik')->count() }} orang</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">IPK Rata-rata:</span>
                            <span class="font-bold text-purple-600">
                                {{ $daftarBeasiswa->where('pilihan_beasiswa', 'Non-Akademik')->count() > 0 
                                    ? number_format($daftarBeasiswa->where('pilihan_beasiswa', 'Non-Akademik')->avg('ipk'), 2) 
                                    : '0.00' }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Prestasi Olahraga -->
                <div class="border-2 border-orange-200 rounded-lg p-6 hover:shadow-lg transition">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-bold text-orange-600">Prestasi Olahraga</h3>
                        <span class="text-3xl">🏆</span>
                    </div>
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Jumlah:</span>
                            <span class="font-bold">{{ $daftarBeasiswa->where('pilihan_beasiswa', 'Prestasi Olahraga')->count() }} orang</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">IPK Rata-rata:</span>
                            <span class="font-bold text-orange-600">
                                {{ $daftarBeasiswa->where('pilihan_beasiswa', 'Prestasi Olahraga')->count() > 0 
                                    ? number_format($daftarBeasiswa->where('pilihan_beasiswa', 'Prestasi Olahraga')->avg('ipk'), 2) 
                                    : '0.00' }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Prestasi Seni -->
                <div class="border-2 border-pink-200 rounded-lg p-6 hover:shadow-lg transition">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-bold text-pink-600">Prestasi Seni</h3>
                        <span class="text-3xl">🎨</span>
                    </div>
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Jumlah:</span>
                            <span class="font-bold">{{ $daftarBeasiswa->where('pilihan_beasiswa', 'Prestasi Seni')->count() }} orang</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">IPK Rata-rata:</span>
                            <span class="font-bold text-pink-600">
                                {{ $daftarBeasiswa->where('pilihan_beasiswa', 'Prestasi Seni')->count() > 0 
                                    ? number_format($daftarBeasiswa->where('pilihan_beasiswa', 'Prestasi Seni')->avg('ipk'), 2) 
                                    : '0.00' }}
                            </span>
                        </div>
                    </div>
                </div>
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