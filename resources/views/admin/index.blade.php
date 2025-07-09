@extends('layouts.app')

@section('content')
@if(session('error') || session('success'))
    @php
        $type = session('error') ? 'error' : 'success';
        $message = session($type);
        $bgColor = $type === 'error' ? 'bg-red-500' : 'bg-green-500';
        $id = $type . 'Message';
        $closeFunction = 'close' . ucfirst($type) . 'Message';
    @endphp

    <div id="{{ $id }}" class="{{ $bgColor }} text-white p-4 rounded-lg mb-6 relative shadow-md animate__animated animate__fadeInDown">
        <span>{{ $message }}</span>
        <button class="absolute right-5 top-2 text-white font-bold text-lg"
                onclick="document.getElementById('{{ $id }}').classList.add('hidden')">
            &times;
        </button>
    </div>

    <script>
        setTimeout(() => {
            const el = document.getElementById('{{ $id }}');
            if (el) el.classList.add('hidden');
        }, 5000);
    </script>
@endif

{{-- Judul --}}
<div class="bg-gradient-to-r from-purple-600 via-blue-500 to-indigo-600 p-8 rounded-xl shadow-xl mb-6 text-white text-center">
    <h1 class="text-4xl font-extrabold mb-2">🎯 Manajemen Lomba</h1>
    <p class="text-lg font-light">Kelola lomba dengan mudah dan efisien. Tambahkan, ubah, atau hapus lomba sesuai kebutuhan Anda.</p>
</div>

{{-- Tombol Aksi --}}
<div class="mb-6 flex flex-wrap gap-4 justify-center">
    <a href="{{ route('admin.create') }}" class="bg-green-500 hover:bg-green-600 text-white py-2 px-6 rounded-full shadow-lg flex items-center gap-2 transition">
        ➕ Tambah Lomba
    </a>
    <a href="{{ route('home') }}" class="bg-red-500 hover:bg-red-600 text-white py-2 px-6 rounded-full shadow-lg flex items-center gap-2 transition">
        🔙 Kembali
    </a>
</div>

{{-- Kartu Lomba --}}
<div class="bg-white p-6 rounded-xl shadow-xl">
    @forelse ($lombas as $lomba)
        <div class="bg-gradient-to-tr from-white to-indigo-50 border border-gray-200 rounded-xl shadow-md hover:shadow-2xl transform hover:-translate-y-1 transition duration-300 overflow-hidden mb-6 group">
            @if($lomba->image)
                <img src="{{ asset('storage/' . $lomba->image) }}" alt="{{ $lomba->title }}" class="w-full h-48 object-cover rounded-t-xl">
            @endif

            <div class="p-5">
                <div class="flex justify-between items-center mb-3">
                    <h2 class="text-2xl font-bold text-gray-800">{{ $lomba->title }}</h2>
                    <div class="flex gap-2">
                        <a href="{{ route('admin.edit', $lomba) }}" class="text-blue-600 hover:text-blue-800 font-semibold text-sm flex items-center gap-1">
                            ✏️ Edit
                        </a>
                        <form action="{{ route('admin.destroy', $lomba) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus lomba ini?')" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800 font-semibold text-sm flex items-center gap-1">
                                🗑️ Hapus
                            </button>
                        </form>
                    </div>
                </div>

                <p class="text-gray-600 text-sm mb-4 text-justify">
                    {{ Str::limit($lomba->content, 100) }}
                </p>

                <a href="{{ route('lombas.show', $lomba->id) }}" class="inline-block text-indigo-600 hover:text-indigo-800 font-semibold text-sm transition">
                    ➜ Baca Selengkapnya
                </a>
            </div>
        </div>
    @empty
        <div class="text-center text-gray-500 py-12 text-lg font-medium">
            ❗ Tidak ada lomba yang tersedia saat ini.
        </div>
    @endforelse
</div>
@endsection
