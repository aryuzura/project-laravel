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

    <div id="{{ $id }}" class="{{ $bgColor }} text-white p-4 rounded-lg mb-6 mx-auto max-w-md shadow-md relative z-50">
        <span>{{ $message }}</span>
        <button class="absolute right-4 top-2 text-white font-bold" onclick="{{ $closeFunction }}()">✖</button>
    </div>

    <script>
        function {{ $closeFunction }}() {
            document.getElementById('{{ $id }}').classList.add('hidden');
        }

        setTimeout(function() {
            var el = document.getElementById('{{ $id }}');
            if (el) el.classList.add('hidden');
        }, 5000);
    </script>
@endif

<div class="flex justify-center items-center min-h-[80vh] px-4">
    <div class="w-full max-w-md bg-white p-8 rounded-3xl shadow-2xl border border-gray-200">
        <div class="text-center mb-6">
            <h2 class="text-4xl font-bold text-gray-800 mb-1">Selamat Datang!</h2>
            <p class="text-sm text-gray-600">Silakan login untuk melanjutkan</p>
            <div class="mt-4 w-16 h-1 mx-auto bg-blue-500 rounded-full"></div>
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                    class="mt-1 w-full px-4 py-2 border rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 @error('email') border-red-500 @enderror">
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input id="password" type="password" name="password" required
                    class="mt-1 w-full px-4 py-2 border rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 @error('password') border-red-500 @enderror">
                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center mb-6">
                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}
                    class="mr-2 accent-blue-600">
                <label for="remember" class="text-sm text-gray-600">Ingat Saya</label>
            </div>

            <div class="flex justify-center">
                <button type="submit"
                    class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white px-6 py-2 rounded-full font-semibold hover:from-blue-600 hover:to-indigo-700 transition-all duration-300 shadow-md hover:shadow-xl">
                    Login
                </button>
            </div>
        </form>

        <div class="mt-6 text-center">
            <p class="text-sm text-gray-600">Belum punya akun?
                <a href="{{ route('register') }}" class="text-blue-600 hover:underline font-medium">Daftar di sini</a>
            </p>
        </div>
    </div>
</div>
@endsection
