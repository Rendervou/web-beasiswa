@extends('layouts.app')

@section('title', 'Daftar Beasiswa')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <h1 class="text-4xl font-bold mb-2 text-center">Formulir Pendaftaran Beasiswa</h1>
    <p class="text-center text-gray-600 mb-8">Lengkapi data berikut dengan benar</p>
    
    <!-- Info IPK -->
    <div class="mb-6 p-6 rounded-lg {{ $isEligible ? 'bg-green-50 border-2 border-green-500' : 'bg-red-50 border-2 border-red-500' }}">
        <div class="flex items-center">
            <div class="text-5xl mr-4">
                {{ $isEligible ? '✅' : '❌' }}
            </div>
            <div>
                <h3 class="text-xl font-bold {{ $isEligible ? 'text-green-800' : 'text-red-800' }}">
                    IPK Anda: {{ number_format($ipk, 2) }}
                </h3>
                @if($isEligible)
                    <p class="text-green-700 font-semibold">Selamat! Anda memenuhi syarat untuk mendaftar beasiswa (IPK ≥ 3.0)</p>
                @else
                    <p class="text-red-700 font-semibold">Maaf, IPK Anda belum memenuhi syarat minimal 3.0</p>
                    <p class="text-red-600 text-sm mt-1">Form pendaftaran tidak dapat diisi karena IPK di bawah 3.0</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow-lg p-8">
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <strong class="font-bold">Terdapat kesalahan:</strong>
                <ul class="list-disc list-inside mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('beasiswa.store') }}" method="POST" enctype="multipart/form-data" id="formBeasiswa">
            @csrf
            
            <!-- Nama -->
            <div class="mb-6">
                <label class="block text-gray-700 font-bold mb-2">
                    Nama Lengkap <span class="text-red-500">*</span>
                </label>
                <input type="text" name="nama" value="{{ old('nama') }}" 
                    {{ !$isEligible ? 'disabled' : '' }}
                    class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 {{ !$isEligible ? 'bg-gray-100 cursor-not-allowed' : '' }}" 
                    placeholder="Masukkan nama lengkap"
                    required>
                <p class="text-sm text-gray-500 mt-1">Contoh: Ahmad Maulana</p>
            </div>

            <!-- Email -->
            <div class="mb-6">
                <label class="block text-gray-700 font-bold mb-2">
                    Email <span class="text-red-500">*</span>
                </label>
                <input type="email" name="email" value="{{ old('email') }}" 
                    {{ !$isEligible ? 'disabled' : '' }}
                    class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 {{ !$isEligible ? 'bg-gray-100 cursor-not-allowed' : '' }}" 
                    placeholder="nama@email.com"
                    required>
                <p class="text-sm text-gray-500 mt-1">Gunakan email aktif untuk notifikasi</p>
            </div>

            <!-- Nomor HP -->
            <div class="mb-6">
                <label class="block text-gray-700 font-bold mb-2">
                    Nomor HP <span class="text-red-500">*</span>
                </label>
                <input type="number" name="nomor_hp" value="{{ old('nomor_hp') }}" 
                    {{ !$isEligible ? 'disabled' : '' }}
                    class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 {{ !$isEligible ? 'bg-gray-100 cursor-not-allowed' : '' }}" 
                    placeholder="08123456789"
                    required>
                <p class="text-sm text-gray-500 mt-1">Nomor HP hanya angka, tanpa spasi atau tanda hubung</p>
            </div>

            <!-- Semester -->
            <div class="mb-6">
                <label class="block text-gray-700 font-bold mb-2">
                    Semester Saat Ini <span class="text-red-500">*</span>
                </label>
                <select name="semester" 
                    {{ !$isEligible ? 'disabled' : '' }}
                    class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 {{ !$isEligible ? 'bg-gray-100 cursor-not-allowed' : '' }}" 
                    required>
                    <option value="">-- Pilih Semester --</option>
                    @for($i = 1; $i <= 8; $i++)
                        <option value="{{ $i }}" {{ old('semester') == $i ? 'selected' : '' }}>
                            Semester {{ $i }}
                        </option>
                    @endfor
                </select>
                <p class="text-sm text-gray-500 mt-1">Pilih semester 1-8 (S1)</p>
            </div>

            <!-- IPK (Readonly) -->
            <div class="mb-6">
                <label class="block text-gray-700 font-bold mb-2">
                    IPK Terakhir
                </label>
                <input type="text" value="{{ number_format($ipk, 2) }}" 
                    class="w-full px-4 py-3 border rounded-lg bg-gray-100 cursor-not-allowed font-bold text-lg {{ $isEligible ? 'text-green-600' : 'text-red-600' }}" 
                    readonly>
                <p class="text-sm text-gray-500 mt-1">IPK didapat otomatis dari sistem</p>
            </div>

            <!-- Pilihan Beasiswa -->
            <div class="mb-6">
                <label class="block text-gray-700 font-bold mb-2">
                    Pilihan Beasiswa <span class="text-red-500">*</span>
                </label>
                <select name="pilihan_beasiswa" id="pilihanBeasiswa"
                    {{ !$isEligible ? 'disabled' : '' }}
                    class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 {{ !$isEligible ? 'bg-gray-100 cursor-not-allowed' : '' }}" 
                    required>
                    <option value="">-- Pilih Jenis Beasiswa --</option>
                    <option value="Akademik" {{ old('pilihan_beasiswa') == 'Akademik' ? 'selected' : '' }}>
                        Beasiswa Akademik
                    </option>
                    <option value="Non-Akademik" {{ old('pilihan_beasiswa') == 'Non-Akademik' ? 'selected' : '' }}>
                        Beasiswa Non-Akademik
                    </option>
                    <option value="Prestasi Olahraga" {{ old('pilihan_beasiswa') == 'Prestasi Olahraga' ? 'selected' : '' }}>
                        Beasiswa Prestasi Olahraga
                    </option>
                    <option value="Prestasi Seni" {{ old('pilihan_beasiswa') == 'Prestasi Seni' ? 'selected' : '' }}>
                        Beasiswa Prestasi Seni
                    </option>
                </select>
                <p class="text-sm text-gray-500 mt-1">Pilih sesuai dengan prestasi Anda</p>
            </div>

            <!-- Upload Berkas -->
            <div class="mb-6">
                <label class="block text-gray-700 font-bold mb-2">
                    Upload Berkas Syarat <span class="text-red-500">*</span>
                </label>
                <input type="file" name="berkas" id="berkas"
                    {{ !$isEligible ? 'disabled' : '' }}
                    class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 {{ !$isEligible ? 'bg-gray-100 cursor-not-allowed' : '' }}" 
                    accept=".pdf,.jpg,.jpeg,.png,.zip"
                    required>
                <p class="text-sm text-gray-500 mt-1">
                    Format: PDF, JPG, PNG, atau ZIP | Maksimal: 2MB
                </p>
                <div id="filePreview" class="mt-2 text-sm text-blue-600 hidden"></div>
            </div>

            <!-- Info Tambahan -->
            <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6">
                <h4 class="font-bold text-blue-800 mb-2">Dokumen yang harus diupload:</h4>
                <ul class="text-sm text-blue-900 space-y-1">
                    <li>• Transkrip nilai semester terakhir</li>
                    <li>• Surat keterangan aktif kuliah</li>
                    <li>• Sertifikat/piagam prestasi (jika ada)</li>
                    <li>• KTP/Kartu Mahasiswa</li>
                </ul>
            </div>

            <!-- Buttons -->
            <div class="flex space-x-4">
                <button type="reset" 
                    {{ !$isEligible ? 'disabled' : '' }}
                    class="flex-1 bg-gray-500 text-white px-6 py-3 rounded-lg font-semibold hover:bg-gray-600 transition {{ !$isEligible ? 'opacity-50 cursor-not-allowed' : '' }}">
                    Reset Form
                </button>
                <button type="submit" 
                    {{ !$isEligible ? 'disabled' : '' }}
                    class="flex-1 bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition {{ !$isEligible ? 'opacity-50 cursor-not-allowed' : '' }}">
                    Daftar Beasiswa
                </button>
            </div>

            @if(!$isEligible)
                <div class="mt-4 text-center">
                    <p class="text-red-600 font-semibold">
                        ⚠️ Anda tidak dapat mendaftar karena IPK di bawah 3.0
                    </p>
                </div>
            @endif
        </form>
    </div>

    <!-- Info Status -->
    <div class="mt-8 bg-yellow-50 border border-yellow-400 rounded-lg p-6">
        <h3 class="font-bold text-yellow-800 mb-2">📌 Informasi Penting</h3>
        <ul class="text-sm text-yellow-900 space-y-2">
            <li>• Setelah submit, status ajuan akan menjadi <strong>"Belum diverifikasi"</strong></li>
            <li>• Proses verifikasi memakan waktu 3-7 hari kerja</li>
            <li>• Anda akan mendapat notifikasi melalui email</li>
            <li>• Pastikan data yang diisi sudah benar sebelum submit</li>
        </ul>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Auto focus ke pilihan beasiswa jika IPK >= 3.0
    document.addEventListener('DOMContentLoaded', function() {
        const ipk = {{ $ipk }};
        const isEligible = {{ $isEligible ? 'true' : 'false' }};
        
        if (isEligible) {
            // Auto focus ke pilihan beasiswa setelah form terisi
            const pilihanBeasiswa = document.getElementById('pilihanBeasiswa');
            if (pilihanBeasiswa && !pilihanBeasiswa.value) {
                // Fokus ke pilihan beasiswa setelah user mengisi semester
                document.querySelector('select[name="semester"]')?.addEventListener('change', function() {
                    setTimeout(() => {
                        pilihanBeasiswa.focus();
                    }, 100);
                });
            }
        }
    });

    // Preview file yang diupload
    document.getElementById('berkas')?.addEventListener('change', function(e) {
        const file = e.target.files[0];
        const preview = document.getElementById('filePreview');
        
        if (file) {
            const fileSize = (file.size / 1024 / 1024).toFixed(2); // MB
            preview.innerHTML = `
                <div class="flex items-center space-x-2">
                    <span>📎</span>
                    <span><strong>${file.name}</strong> (${fileSize} MB)</span>
                </div>
            `;
            preview.classList.remove('hidden');
            
            // Validasi ukuran file
            if (fileSize > 2) {
                alert('Ukuran file terlalu besar! Maksimal 2MB');
                e.target.value = '';
                preview.classList.add('hidden');
            }
        } else {
            preview.classList.add('hidden');
        }
    });

    // Konfirmasi sebelum submit
    document.getElementById('formBeasiswa')?.addEventListener('submit', function(e) {
        const isEligible = {{ $isEligible ? 'true' : 'false' }};
        
        if (!isEligible) {
            e.preventDefault();
            alert('Anda tidak dapat mendaftar karena IPK di bawah 3.0');
            return false;
        }
        
        if (!confirm('Apakah Anda yakin data yang diisi sudah benar?')) {
            e.preventDefault();
            return false;
        }
    });
</script>
@endpush