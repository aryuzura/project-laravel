@extends('layouts.app')

@section('content')
<div class="flex justify-center items-center min-h-[80vh] px-4">
    <div class="w-full max-w-md bg-white p-8 rounded-3xl shadow-2xl border border-blue-300">
        <div class="text-center mb-6">
            <h2 class="text-3xl font-bold text-blue-700 mb-1">Daftar Akun Baru</h2>
            <p class="text-sm text-gray-600">Isi data berikut untuk membuat akun</p>
            <div class="mt-4 w-16 h-1 mx-auto bg-blue-500 rounded-full"></div>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-blue-700">Nama</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                    class="mt-1 w-full px-4 py-2 border rounded-xl focus:ring-2 focus:ring-blue-400 @error('name') border-red-500 @enderror">
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-blue-700">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required
                    class="mt-1 w-full px-4 py-2 border rounded-xl focus:ring-2 focus:ring-blue-400 @error('email') border-red-500 @enderror">
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-blue-700">Password</label>
                <input id="password" type="password" name="password" required
                    class="mt-1 w-full px-4 py-2 border rounded-xl focus:ring-2 focus:ring-blue-400 @error('password') border-red-500 @enderror">
                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="password-confirm" class="block text-sm font-medium text-blue-700">Konfirmasi Password</label>
                <input id="password-confirm" type="password" name="password_confirmation" required
                    class="mt-1 w-full px-4 py-2 border rounded-xl focus:ring-2 focus:ring-blue-400">
            </div>

            <div class="flex justify-center">
                <button type="submit"
                    class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white px-6 py-2 rounded-full font-semibold hover:from-blue-600 hover:to-indigo-700 transition-all duration-300 shadow-md hover:shadow-xl">
                    Register
                </button>
            </div>
        </form>

        <div class="mt-6 text-center">
            <p class="text-sm text-gray-600">Sudah punya akun?
                <a href="{{ route('login') }}" class="text-blue-600 hover:underline font-medium">Login di sini</a>
            </p>
        </div>
    </div>
</div>
@endsection
