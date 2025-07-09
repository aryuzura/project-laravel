@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-500 via-purple-500 to-pink-500 mb-8">
        ✨ Profil Saya
    </h1>

    {{-- Alert --}}
    @if(session('success') || session('error'))
        @php
            $type = session('success') ? 'success' : 'error';
            $message = session($type);
            $bgColor = $type === 'success' ? 'from-green-400 to-green-600 text-green-900' : 'from-red-400 to-red-600 text-red-900';
            $icon = $type === 'success' ? '✅' : '⚠️';
            $id = $type . 'Alert';
            $closeFn = 'close' . ucfirst($type) . 'Alert';
        @endphp

        <div id="{{ $id }}"
             class="bg-gradient-to-r {{ $bgColor }} px-6 py-4 rounded-xl mb-6 shadow-md relative font-medium">
            <span class="text-xl">{{ $icon }} {{ $message }}</span>
            <button class="absolute right-4 top-2 text-xl font-bold" onclick="{{ $closeFn }}()">×</button>
        </div>

        <script>
            function {{ $closeFn }}() {
                document.getElementById('{{ $id }}').classList.add('hidden');
            }
            setTimeout(() => {
                const el = document.getElementById('{{ $id }}');
                if (el) el.classList.add('hidden');
            }, 5000);
        </script>
    @endif

    {{-- Form Profil --}}
    <form method="POST" action="{{ route('mahasiswa.profile.update') }}"
          class="bg-gradient-to-br from-white via-blue-50 to-purple-100 p-8 rounded-2xl shadow-2xl space-y-6 border border-blue-100">
        @csrf
        @method('PUT')

        <div>
            <label for="name" class="block text-sm font-semibold text-blue-800 mb-1">👤 Nama Lengkap</label>
            <input type="text" name="name" id="name"
                   value="{{ old('name', $user->name) }}"
                   class="w-full p-3 border border-blue-200 rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none bg-white"
                   required>
        </div>

        <div>
            <label for="email" class="block text-sm font-semibold text-blue-800 mb-1">📧 Email</label>
            <input type="email" name="email" id="email"
                   value="{{ old('email', $user->email) }}"
                   class="w-full p-3 border border-blue-200 rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none bg-white"
                   required>
        </div>

        <div>
            <label for="kelas" class="block text-sm font-semibold text-blue-800 mb-1">🏫 Kelas</label>
            <input type="text" name="kelas" id="kelas"
                   value="{{ old('kelas', $user->kelas) }}"
                   placeholder="Contoh: TI-4A"
                   class="w-full p-3 border border-blue-200 rounded-lg focus:ring-2 focus:ring-purple-400 focus:outline-none bg-white"
                   required>
        </div>

        <div>
            <label for="asal_kampus" class="block text-sm font-semibold text-blue-800 mb-1">🎓 Asal Kampus</label>
            <input type="text" name="asal_kampus" id="asal_kampus"
                   value="{{ old('asal_kampus', $user->asal_kampus) }}"
                   placeholder="Contoh: Universitas Teknologi"
                   class="w-full p-3 border border-blue-200 rounded-lg focus:ring-2 focus:ring-pink-400 focus:outline-none bg-white"
                   required>
        </div>

        <hr class="my-6 border-blue-200">

        <p class="text-sm text-gray-700 italic">🔒 Kosongkan password jika tidak ingin mengubahnya.</p>

        <div>
            <label for="password" class="block text-sm font-semibold text-blue-800 mb-1">🔑 Password Baru</label>
            <input type="password" name="password" id="password"
                   class="w-full p-3 border border-purple-200 rounded-lg focus:ring-2 focus:ring-purple-400 bg-white">
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-semibold text-blue-800 mb-1">🔁 Konfirmasi Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation"
                   class="w-full p-3 border border-purple-200 rounded-lg focus:ring-2 focus:ring-purple-400 bg-white">
        </div>

        <div class="flex gap-4 mt-8">
            <button type="submit"
                    class="bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white px-6 py-3 rounded-full font-semibold shadow-md transition duration-300">
                💾 Simpan Perubahan
            </button>
            <a href="{{ route('home') }}"
               class="bg-gradient-to-r from-red-500 to-pink-500 hover:from-red-600 hover:to-pink-600 text-white px-6 py-3 rounded-full font-semibold shadow-md transition duration-300">
                🔙 Kembali
            </a>
        </div>
    </form>
</div>
@endsection
