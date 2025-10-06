<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sistem Pendaftaran Beasiswa')</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        .navbar-link {
            transition: all 0.3s ease;
        }
        .navbar-link:hover {
            color: #2563EB;
            transform: translateY(-2px);
        }
        .active {
            background-color: #2563EB;
            color: white;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('beasiswa.home') }}" class="flex items-center space-x-2">
                        <span class="text-3xl">🎓</span>
                        <span class="text-2xl font-bold text-blue-600">Beasiswa Kampus</span>
                    </a>
                </div>
                <div class="flex items-center space-x-2">
                    <a href="{{ route('beasiswa.home') }}" 
                        class="navbar-link px-4 py-2 rounded-md {{ request()->routeIs('beasiswa.home') ? 'active' : 'text-gray-700 hover:text-blue-600' }} font-medium">
                        🏠 Home
                    </a>
                    <a href="{{ route('beasiswa.pilihan') }}" 
                        class="navbar-link px-4 py-2 rounded-md {{ request()->routeIs('beasiswa.pilihan') ? 'active' : 'text-gray-700 hover:text-blue-600' }} font-medium">
                        📚 Pilihan Beasiswa
                    </a>
                    <a href="{{ route('beasiswa.daftar') }}" 
                        class="navbar-link px-4 py-2 rounded-md {{ request()->routeIs('beasiswa.daftar') ? 'active' : 'text-gray-700 hover:text-blue-600' }} font-medium">
                        📝 Daftar
                    </a>
                    <a href="{{ route('beasiswa.hasil') }}" 
                        class="navbar-link px-4 py-2 rounded-md {{ request()->routeIs('beasiswa.hasil') ? 'active' : 'text-gray-700 hover:text-blue-600' }} font-medium">
                        📊 Hasil
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Berhasil!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Error!</strong>
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        </div>
    @endif

    <!-- Content -->
    <main class="py-8">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="grid md:grid-cols-3 gap-8">
                <div>
                    <h3 class="text-lg font-bold mb-4">Tentang Kami</h3>
                    <p class="text-gray-300">Sistem Pendaftaran Beasiswa Online untuk memudahkan mahasiswa mendaftar beasiswa.</p>
                </div>
                <div>
                    <h3 class="text-lg font-bold mb-4">Kontak</h3>
                    <p class="text-gray-300">Email: beasiswa@kampus.ac.id</p>
                    <p class="text-gray-300">Telp: (021) 1234-5678</p>
                </div>
                <div>
                    <h3 class="text-lg font-bold mb-4">Jam Layanan</h3>
                    <p class="text-gray-300">Senin - Jumat: 08:00 - 16:00</p>
                    <p class="text-gray-300">Sabtu - Minggu: Tutup</p>
                </div>
            </div>
            <div class="text-center mt-8 pt-8 border-t border-gray-700">
                <p>&copy; 2025 Sistem Beasiswa Kampus. All rights reserved.</p>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>