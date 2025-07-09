@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
@endpush


@section('content')
@if(session('error') || session('success'))
    @php
        $type = session('error') ? 'error' : 'success';
        $message = session($type);
        $bgColor = $type === 'error' ? 'bg-red-500' : 'bg-green-500';
        $id = $type . 'Message';
    @endphp

    <div id="{{ $id }}" class="{{ $bgColor }} text-white p-4 rounded-lg mb-6 relative shadow-md animate-fade-in-down">
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

{{-- Sambutan --}}
<div class="bg-gradient-to-r from-fuchsia-500 via-indigo-500 to-cyan-500 p-6 rounded-xl shadow-lg mb-6 text-white animate__animated animate__fadeInDown">
    @auth
        @if(Auth::user()->role === 'admin')
            <h1 class="text-3xl font-extrabold mb-2">👨‍💼 Halo Admin, {{ Auth::user()->name }}!</h1>
            <p class="text-lg mb-2">Kelola lomba dan pantau partisipasi peserta dengan mudah 🚀</p>
           
        @elseif(Auth::user()->role === 'mahasiswa')
            <h1 class="text-3xl font-extrabold mb-2">🎉 Halo, {{ Auth::user()->name }}!</h1>
            <p class="text-lg mb-2">Cek lomba terbaru dan wujudkan potensimu 💪</p>
        @else
            <h1 class="text-3xl font-extrabold mb-2">👋 Selamat datang!</h1>
            <p class="text-lg">Silakan gunakan fitur sesuai hak akses Anda.</p>
        @endif
    @else
        <h1 class="text-3xl font-extrabold mb-2">👋 Selamat datang!</h1>
        <p class="text-lg">
            <a href="{{ route('login') }}" class="underline hover:text-gray-100 font-semibold">Login</a> atau
            <a href="{{ route('register') }}" class="underline hover:text-gray-100 font-semibold">Register</a> untuk mulai ikut lomba!
        </p>
    @endauth
</div>



{{-- Slider Lomba Terbaru --}}
<div class="bg-white p-6 rounded-xl shadow-lg mb-6 animate__animated animate__fadeInUp">
    <h2 class="text-2xl font-bold text-gray-800 mb-4 border-b pb-2">🔥 Lomba Terbaru</h2>

    @if ($lombas->isEmpty())
        <div class="text-center py-8 text-gray-500">Belum ada lomba terbaru saat ini.</div>
    @else
        <div class="swiper mySwiper relative w-full h-80 rounded-xl overflow-hidden shadow-xl">
            <div class="swiper-wrapper">
                @foreach ($lombas as $lomba)
                    <div class="swiper-slide">
                        <div class="relative w-full h-80">
                            <img src="{{ asset('storage/' . $lomba->image) }}"
                                 class="w-full h-full object-cover rounded-xl transition duration-700"
                                 alt="{{ $lomba->title }}" />
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent flex flex-col justify-end p-6 rounded-xl">
                                <h3 class="text-white text-2xl font-extrabold">{{ $lomba->title }}</h3>
                                <a href="{{ route('lombas.show', $lomba->id) }}"
                                   class="text-pink-300 hover:underline text-sm mt-2">
                                    ✨ Lihat Detail →
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="swiper-pagination !bottom-3"></div>
            <div class="swiper-button-prev text-white drop-shadow-2xl"></div>
            <div class="swiper-button-next text-white drop-shadow-2xl"></div>
        </div>
    @endif
</div>


{{-- Kartu Lomba --}}
@if(auth()->check() && auth()->user()->role === 'mahasiswa')
<div class="bg-white p-6 rounded-xl shadow-lg animate__animated animate__fadeInUp">
    <h2 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-2">🎯 Lomba Yang Tersedia</h2>

    @if($lombas->isEmpty())
        <div class="text-center py-8 text-gray-500">Belum ada lomba yang bisa diikuti saat ini.</div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach ($lombas as $lomba)
                <div class="bg-gradient-to-br from-white to-blue-50 rounded-xl shadow-lg hover:shadow-2xl transform hover:scale-105 transition-all duration-300 overflow-hidden">
                    @if($lomba->image)
                        <img src="{{ asset('storage/' . $lomba->image) }}"
                             alt="{{ $lomba->title }}" class="w-full h-40 object-cover">
                    @endif
                    <div class="p-4">
                        <h3 class="text-lg font-bold text-gray-800 mb-2">{{ $lomba->title }}</h3>
                        <p class="text-sm text-gray-600 mb-4">{{ Str::limit($lomba->content, 100) }}</p>
                        <a href="{{ route('lombas.show', $lomba->id) }}"
                           class="inline-block text-indigo-600 hover:text-indigo-800 font-semibold text-sm transition">
                            ➜ Baca Selengkapnya
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

@endif
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const swiper = new Swiper('.mySwiper', {
            loop: true,
            autoplay: {
                delay: 3500,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            effect: 'fade',
            fadeEffect: {
                crossFade: true
            },
            speed: 1000
        });
    });
</script>
@endpush
