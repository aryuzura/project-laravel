@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-500 via-purple-500 to-pink-500 mb-8 text-center">
        🎉 Tambahkan Lomba Baru
    </h1>

    <form method="POST" action="{{ route('admin.store') }}" enctype="multipart/form-data" class="bg-gradient-to-br from-white via-gray-50 to-gray-100 p-8 rounded-xl shadow-xl">
        @csrf

        {{-- Judul --}}
        <div class="mb-6">
            <label for="title" class="block text-gray-700 font-semibold mb-2">📌 Judul Lomba</label>
            <input type="text" name="title" id="title" placeholder="Contoh: Lomba Desain Logo"
                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-transparent transition" required>
        </div>

        {{-- Konten --}}
        <div class="mb-6">
            <label for="content" class="block text-gray-700 font-semibold mb-2">📝 Konten Lomba</label>
            <textarea name="content" id="content" rows="5" placeholder="Deskripsikan lomba secara lengkap..."
                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-400 focus:border-transparent transition" required></textarea>
        </div>

        {{-- Gambar --}}
        <div class="mb-6">
            <label for="image" class="block text-gray-700 font-semibold mb-2">🖼️ Gambar Lomba</label>
            <input type="file" name="image" id="image" accept="image/*" onchange="previewImage(event)"
                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition">

            <div id="imagePreview" class="mt-4">
                <p id="imageMessage" class="text-sm text-gray-600 mb-2 font-medium">
                    🌄 Preview Gambar:
                </p>
                <img id="preview" class="w-64 h-auto rounded-lg shadow-lg hidden border border-dashed border-gray-400" />
            </div>
        </div>

        {{-- Tombol --}}
        <div class="flex justify-between items-center mt-8">
            <a href="{{ route('admin.index') }}"
                class="inline-block bg-gradient-to-r from-pink-200 via-pink-300 to-pink-400 text-gray-800 px-6 py-2 rounded-full font-semibold shadow hover:scale-105 transition">
                ⬅️ Kembali
            </a>
            <button type="submit"
                class="inline-block bg-gradient-to-r from-green-400 via-green-500 to-green-600 text-white px-6 py-2 rounded-full font-semibold shadow hover:scale-105 transition">
                ✅ Simpan Lomba
            </button>
        </div>
    </form>
</div>

{{-- Script Preview --}}
<script>
    function previewImage(event) {
        const message = document.getElementById('imageMessage');
        const preview = document.getElementById('preview');
        const file = event.target.files[0];

        if (file) {
            preview.src = URL.createObjectURL(file);
            preview.classList.remove('hidden');
            message.innerHTML = '🌄 Preview Gambar:';
        } else {
            preview.src = '';
            preview.classList.add('hidden');
            message.innerHTML = '<span class="text-gray-400">Tidak Ada Gambar</span>';
        }
    }
</script>
@endsection
