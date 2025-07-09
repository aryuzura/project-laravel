@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-purple-500 to-pink-500">
            🔔 Riwayat Notifikasi
        </h1>

        @if($notifications->where('is_read', false)->count() > 0)
        <form action="{{ route('notifications.read.all') }}" method="POST">
            @csrf
            <button type="submit"
                class="bg-gradient-to-r from-green-400 to-green-600 text-white px-4 py-2 rounded-full shadow hover:scale-105 transition">
                ✅ Tandai Semua Telah Dibaca
            </button>
        </form>
        @endif
    </div>

    <a href="{{ route('home') }}"
        class="inline-block bg-gradient-to-r from-red-500 to-red-700 text-white px-6 py-2 rounded-full hover:scale-105 shadow transition mb-8">
        ⬅️ Kembali ke Beranda
    </a>

    <div class="bg-white p-6 rounded-2xl shadow-xl space-y-4">
        @forelse ($notifications as $notification)
            <a href="{{ route('notifications.read', $notification->id) }}"
               class="block border-l-4 transition duration-300 px-6 py-4 rounded-lg shadow-sm 
                   {{ $notification->is_read ? 'border-gray-400 bg-gray-50' : 'border-blue-500 bg-blue-50 hover:bg-blue-100' }}">
                <div class="flex justify-between items-center mb-2">
                    <h3 class="text-lg font-semibold flex items-center space-x-2">
                        {!! $notification->is_read ? '📭' : '📬' !!}

                        @php
                            // Tandai jika notifikasi adalah tentang pendaftaran lomba
                            $isPendaftaran = str_contains(strtolower($notification->message), 'mendaftar lomba');
                        @endphp

                        <span class="{{ $notification->is_read ? 'text-gray-700' : 'text-blue-900' }}">
                            @if($isPendaftaran)
                                👨‍🎓 <strong>{{ $notification->message }}</strong>
                            @else
                                {{ $notification->message }}
                            @endif
                        </span>
                    </h3>
                    <span class="text-sm text-gray-500 italic">{{ $notification->created_at->diffForHumans() }}</span>
                </div>
            </a>
        @empty
            <p class="text-gray-500 text-center py-12 text-lg">🚫 Tidak ada notifikasi tersedia.</p>
        @endforelse

        <div class="mt-6">
            {{ $notifications->links('pagination::tailwind') }}
        </div>
    </div>
</div>
@endsection
