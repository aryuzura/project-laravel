@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <div class="bg-gradient-to-r from-yellow-400 via-orange-500 to-pink-500 text-white rounded-lg p-6 shadow-lg mb-6 text-center">
        <h1 class="text-3xl font-extrabold">✏️ Edit Data Lomba</h1>
        <p class="text-sm mt-2 font-light">Perbarui informasi lomba sesuai kebutuhan Anda.</p>
    </div>

    <form action="{{ route('admin.update', $lomba->id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-8 rounded-xl shadow-2xl space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label for="title" class="block text-gray-800 font-semibold mb-2">📌 Judul Lomba</label>
            <input type="text" name="title" id="title" value="{{ $lomba->title }}"
                   placeholder="Masukkan Judul Lomba"
                   class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500" required>
        </div>

        <div>
            <label for="content" class="block text-gray-800 font-semibold mb-2">📝 Konten Lomba</label>
            <textarea name="content" id="content" rows="6"
                      placeholder="Masukkan deskripsi atau informasi lomba"
                      class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500" required>{{ $lomba->content }}</textarea>
        </div>

        <div>
            <label for="image" class="block text-gray-800 font-semibold mb-2">🖼️ Gambar Lomba (opsional)</label>
            <input type="file" name="image" id="image" accept="image/*" onchange="previewImage(event)"
                   class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500">
        </div>

        @if($lomba->image)
            <div>
                <p class="text-sm text-gray-500">📂 Gambar Saat Ini:</p>
                <img src="{{ asset('storage/' . $lomba->image) }}" alt="Gambar Lomba Lama" class="w-64 rounded shadow mt-2">
            </div>
        @endif

        <div id="imagePreview" class="mt-4">
            <p id="imageMessage" class="text-sm text-gray-500">📷 Preview Gambar Baru:</p>
            <img id="preview" class="w-64 rounded shadow mt-2 hidden" />
        </div>

        <div class="flex gap-4 justify-start pt-4">
            <a href="{{ route('admin.index') }}"
               class="flex items-center gap-2 bg-red-500 hover:bg-red-600 text-white px-6 py-2 rounded-full transition duration-300">
                ❌ Batal
            </a>
            <button type="submit"
                    class="flex items-center gap-2 bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-2 rounded-full transition duration-300">
                💾 Simpan Perubahan
            </button>
        </div>
    </form>
</div>

<script>
    function previewImage(event) {
        const preview = document.getElementById('preview');
        const message = document.getElementById('imageMessage');
        const file = event.target.files[0];

        if (file) {
            preview.src = URL.createObjectURL(file);
            preview.classList.remove('hidden');
            message.innerText = "📷 Preview Gambar Baru:";
        } else {
            preview.classList.add('hidden');
            preview.src = '';
            message.innerText = "📷 Preview Gambar Baru: Tidak Ada Gambar";
        }
    }
</script>
@endsection
