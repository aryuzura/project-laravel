<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>SmartCompete</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('/logo.png') }}" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-[Inter] min-h-screen flex flex-col">

<!-- Navbar -->
<nav class="bg-white shadow-md px-6 py-4 flex justify-between items-center">
    <!-- Kiri: Logo + Menu -->
    <div class="flex items-center space-x-6">
        <!-- Logo -->
        <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
            <div class="bg-gradient-to-tr from-blue-500 to-blue-700 p-1 rounded-xl shadow-md transition-transform group-hover:scale-105">
                <img src="{{ asset('/logo.png') }}" alt="Logo" class="h-12 w-auto object-contain rounded-lg">
            </div>
            <span class="text-xl font-bold text-gray-800 tracking-wide hidden sm:inline-block">SmartCompete</span>
        </a>

        <!-- Menu Admin -->
        @if(Auth::check() && Auth::user()->role === 'admin')
            <div class="flex space-x-4 ml-2">
                    <a href="{{ route('admin.index') }}"
                       class="text-sm font-medium transition pb-1
                       {{ Request::routeIs('admin.index') ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-700 hover:text-blue-600' }}">
                        Kelola Lomba
                    </a>
                    <a href="{{ route('admin.create') }}"
                       class="text-sm font-medium transition pb-1
                       {{ Request::routeIs('admin.create') ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-700 hover:text-blue-600' }}">
                        Tambah Lomba
                    </a>
                    <a href="{{ route('admin.dashboard') }}"
                       class="text-sm font-medium transition pb-1
                       {{ Request::routeIs('admin.dashboard') ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-700 hover:text-blue-600' }}">
                        Info Statistik
                    </a>
                </div>
        @endif

        <!-- Menu Mahasiswa -->
        @auth
            @if(Auth::user()->role === 'mahasiswa')
                <div class="flex space-x-4 ml-2">
                    <a href="{{ route('mahasiswa.riwayat.lomba') }}"
                       class="text-sm font-medium transition pb-1
                       {{ Request::routeIs('mahasiswa.riwayat.lomba') ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-700 hover:text-blue-600' }}">
                        Riwayat
                    </a>
                    <a href="{{ route('mahasiswa.profile.edit') }}"
                       class="text-sm font-medium transition pb-1
                       {{ Request::routeIs('mahasiswa.profile.edit') ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-700 hover:text-blue-600' }}">
                        Edit Profil
                    </a>
                </div>
            @endif
        @endauth
    </div>

    <!-- Kanan: Notifikasi + Profil -->
    <div class="flex items-center gap-6">
        @auth
            <!-- Notifikasi: hanya untuk mahasiswa -->
            @auth
                @if(Auth::user()->role === 'mahasiswa')
                    <a href="{{ route('notifications.index') }}" title="Notifikasi"
                       class="text-gray-600 hover:text-blue-600 transition duration-200 text-2xl">
                        <span class="material-icons">notifications</span>
                    </a>
                @endif
            @endauth


            <!-- Profil & Logout -->
            <div class="flex items-center space-x-4 border-l pl-4">
                <div class="flex items-center space-x-2">
                    <span class="material-icons text-gray-600 text-4xl">account_circle</span>
                    <div class="leading-tight">
                        <p class="text-sm font-semibold text-gray-800">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="flex items-center gap-1 text-sm bg-gradient-to-r from-red-500 to-red-700 text-white px-4 py-2 rounded-full shadow hover:from-red-600 hover:to-red-800 transition duration-300">
                        <span class="material-icons text-sm">logout</span> Logout
                    </button>
                </form>
            </div>
        @else
            @if (Request::is('login'))
                <a href="/register" class="flex items-center gap-2 bg-gradient-to-r from-green-500 to-green-700 text-white px-5 py-2 rounded-full shadow hover:from-green-600 hover:to-green-800 transition duration-300">
                    <span class="material-icons text-sm">person_add</span> Register
                </a>
            @else
                <a href="/login" class="flex items-center gap-2 bg-gradient-to-r from-blue-500 to-blue-700 text-white px-5 py-2 rounded-full shadow hover:from-blue-600 hover:to-blue-800 transition duration-300">
                    <span class="material-icons text-sm">login</span> Login
                </a>
            @endif
        @endauth
    </div>
</nav>

<!-- Content -->
<main class="flex-grow container mx-auto px-4 py-6">
    @yield('content')
</main>

<!-- Footer -->
<footer class="bg-white mt-8 shadow-inner border-t border-gray-200">
    <div class="container mx-auto px-6 py-8 flex flex-col sm:flex-row justify-between items-center text-sm text-gray-600">
        <div class="mb-4 sm:mb-0 text-center sm:text-left">
            <p class="font-semibold text-gray-700">&copy; {{ date('Y') }} SmartCompete</p>
            <p>All rights reserved. Designed with 💙 by Kelompok 8 23-01.</p>
        </div>

        <!-- Social Media -->
        <div class="flex gap-4">
            <a href="#" class="text-gray-500 hover:text-blue-600 transition">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M22.23 5.924c-.793.352-1.645.589-2.538.697a4.416 4.416 0 001.94-2.44 8.766 8.766 0 01-2.78 1.063 4.4 4.4 0 00-7.504 4.012 12.496 12.496 0 01-9.073-4.602 4.38 4.38 0 001.362 5.867 4.388 4.388 0 01-1.994-.55v.055a4.402 4.402 0 003.53 4.31 4.405 4.405 0 01-1.99.075 4.408 4.408 0 004.11 3.054 8.828 8.828 0 01-5.47 1.886c-.355 0-.707-.02-1.055-.062a12.45 12.45 0 006.76 1.975c8.112 0 12.542-6.72 12.542-12.542 0-.19-.004-.379-.012-.566a8.963 8.963 0 002.203-2.285z"/>
                </svg>
            </a>
            <a href="#" class="text-gray-500 hover:text-pink-500 transition">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M7.75 2a5.75 5.75 0 00-5.75 5.75v8.5A5.75 5.75 0 007.75 22h8.5A5.75 5.75 0 0022 16.25v-8.5A5.75 5.75 0 0016.25 2h-8.5zm6.5 3.5a1.25 1.25 0 110 2.5 1.25 1.25 0 010-2.5zm-4 2.5a4.5 4.5 0 11-6.364 6.364A4.5 4.5 0 0110.25 8z"/>
                </svg>
            </a>
            <a href="#" class="text-gray-500 hover:text-blue-800 transition">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M22.675 0H1.325C.593 0 0 .593 0 1.325v21.351C0 23.407.593 24 1.325 24h11.497v-9.294H9.692v-3.622h3.13V8.408c0-3.1 1.894-4.788 4.66-4.788 1.325 0 2.462.099 2.794.143v3.24h-1.918c-1.504 0-1.794.715-1.794 1.763v2.312h3.587l-.467 3.622h-3.12V24h6.116c.73 0 1.323-.593 1.323-1.324V1.325C24 .593 23.407 0 22.675 0z"/>
                </svg>
            </a>
        </div>
    </div>
</footer>

</body>
</html>
