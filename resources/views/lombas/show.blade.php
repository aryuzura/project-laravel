@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-indigo-50 via-white to-cyan-100 py-10 px-4 sm:px-8">

    {{-- Notifikasi --}}
    @if(session('error') || session('success'))
        @php
            $type = session('error') ? 'error' : 'success';
            $message = session($type);
            $bgColor = $type === 'error' ? 'bg-red-100 border-red-500 text-red-800' : 'bg-green-100 border-green-500 text-green-800';
            $id = $type . 'Message';
            $closeFunction = 'close' . ucfirst($type) . 'Message';
        @endphp

        <div id="{{ $id }}" class="border-l-8 {{ $bgColor }} px-6 py-4 rounded-lg mb-6 shadow-md relative animate__animated animate__fadeInDown">
            <span class="block font-semibold">{{ $message }}</span>
            <button class="absolute right-4 top-3 text-lg font-bold" onclick="{{ $closeFunction }}()">×</button>
        </div>

        <script>
            function {{ $closeFunction }}() {
                document.getElementById('{{ $id }}').classList.add('hidden');
            }
            setTimeout(() => {
                const el = document.getElementById('{{ $id }}');
                if (el) el.classList.add('hidden');
            }, 5000);
        </script>
    @endif

    {{-- Konten Lomba --}}
    <div class="bg-white p-8 rounded-3xl shadow-xl transition hover:shadow-2xl animate__animated animate__fadeInUp">
        @if($lomba->image)
            <div class="relative cursor-pointer group" onclick="openModal('{{ asset('storage/' . $lomba->image) }}')">
                <img src="{{ asset('storage/' . $lomba->image) }}"
                     alt="{{ $lomba->title }}"
                     class="w-full h-64 object-cover rounded-2xl mb-6 border border-gray-200 shadow-sm transition-transform group-hover:scale-105 duration-300">
                <div class="absolute inset-0 bg-black bg-opacity-30 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center text-white text-sm font-semibold rounded-2xl">
                    Klik untuk perbesar
                </div>
            </div>
        @endif

        <div class="flex justify-between items-center mb-4">
            <h1 class="text-3xl font-extrabold text-indigo-800">{{ $lomba->title }}</h1>
            <p class="text-sm text-gray-500">{{ $lomba->created_at->timezone('Asia/Jakarta')->format('d M Y, H:i') }}</p>
        </div>
        <p class="text-gray-700 leading-relaxed text-justify">{{ $lomba->content }}</p>
    </div>

    {{-- Tombol Daftar --}}
    @auth
    @if(auth()->user()->role == 'mahasiswa')
        <div class="mt-6 text-center animate__animated animate__fadeIn">
            @if($isRegistered)
                <button class="bg-green-400 text-white px-8 py-2 rounded-full shadow cursor-not-allowed" disabled>
                    ✅ Anda Sudah Terdaftar
                </button>
            @else
                <form action="{{ route('mahasiswa.pendaftaran.store', $lomba->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-8 py-2 rounded-full shadow-lg hover:opacity-90 transition-all">
                        ✍️ Daftar Lomba Ini
                    </button>
                </form>
            @endif
        </div>
    @endif
    @endauth

    {{-- Form Komentar --}}
    @if(auth()->check() && (auth()->user()->role == 'mahasiswa' || auth()->user()->role == 'admin'))
        <div class="mt-10 bg-white p-6 rounded-2xl shadow-lg animate__animated animate__fadeInUp">
            <h2 class="text-2xl font-semibold mb-4 text-indigo-800">💬 Tinggalkan Komentar</h2>
            <form method="POST" action="/lombas/{{ $lomba->id }}/comments">
                @csrf
                <textarea name="comment" rows="3"
                          class="w-full border border-gray-300 p-4 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500"
                          placeholder="Tulis komentar Anda..." required></textarea>
                <div class="flex flex-wrap gap-4 mt-4">
                    <button type="submit"
                            class="bg-indigo-600 text-white px-6 py-2 rounded-full hover:bg-indigo-700 transition duration-300 shadow-md">
                        💌 Kirim Komentar
                    </button>
                    <a href="{{ route('home') }}"
                       class="bg-red-500 text-white px-6 py-2 rounded-full hover:bg-red-600 transition duration-300 shadow-md">
                        ⬅️ Kembali
                    </a>
                </div>
            </form>
        </div>
    @endif

    {{-- Komentar --}}
    <div class="mt-10">
        <h2 class="text-2xl font-semibold mb-4 text-indigo-800">🗨 Komentar</h2>
        @forelse($lomba->comments as $comment)
            <div class="bg-white p-5 mb-4 rounded-xl border border-gray-200 shadow-sm animate__animated animate__fadeInUp">
                <div class="flex justify-between items-start">
                    <div class="flex items-center gap-3">
                        <span class="material-icons text-gray-400 text-3xl">account_circle</span>
                        <div>
                            <p class="font-bold text-gray-800">{{ $comment->user->name }}</p>
                            <p class="text-xs text-gray-500">
                                {{ \Carbon\Carbon::parse($comment->created_at)->timezone('Asia/Jakarta')->format('d M Y, H:i') }}
                            </p>
                        </div>
                    </div>
                    @if(auth()->id() == $comment->user_id)
                        <form action="{{ route('comment.destroy', $comment) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 text-sm hover:underline">Hapus</button>
                        </form>
                    @endif
                </div>
                <p class="mt-3 text-gray-700 text-justify">{{ $comment->comment }}</p>
            </div>
        @empty
            <p class="text-gray-500 italic">💤 Belum ada komentar.</p>
        @endforelse
    </div>

    {{-- Modal Gambar Fullscreen --}}
    <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-80 flex items-center justify-center z-50 hidden">
        <div class="relative">
            <img id="modalImage" src="" alt="Preview"
                 class="max-w-full max-h-[90vh] rounded-xl shadow-lg border-4 border-white">
            <button onclick="closeModal()"
                    class="absolute top-2 right-2 bg-red-600 hover:bg-red-700 text-white px-4 py-1 rounded-full text-sm shadow-lg">
                ✖ Tutup
            </button>
        </div>
    </div>

    <script>
        function openModal(imageUrl) {
            const modal = document.getElementById('imageModal');
            const modalImage = document.getElementById('modalImage');
            modalImage.src = imageUrl;
            modal.classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('imageModal').classList.add('hidden');
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeModal();
        });
    </script>

</div>
@endsection
