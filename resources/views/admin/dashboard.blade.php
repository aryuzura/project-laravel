@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-pink-100 via-orange-100 to-yellow-100 py-10 px-6">
    <div class="max-w-6xl mx-auto">
        <div class="mb-6">
            <h1 class="text-4xl font-extrabold text-gray-800 mb-2">📊 Statistik Lomba</h1>
            <p class="text-gray-600">Pantau perkembangan semua lomba yang telah dibuat.</p>
        </div>

        <a href="{{ route('admin.index') }}"
            class="inline-flex items-center bg-red-600 text-white font-semibold px-4 py-2 rounded-full shadow hover:bg-red-700 transition mb-6">
            ⬅️ Kembali ke Dashboard
        </a>

        <div class="bg-white/60 backdrop-blur-md p-6 rounded-xl shadow-lg border border-gray-200">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">📋 Daftar Statistik</h2>
            <div class="overflow-x-auto rounded-lg">
                <table class="min-w-full text-sm text-left text-gray-700">
                    <thead class="bg-orange-500 text-white uppercase text-xs">
                        <tr>
                            <th class="py-3 px-4">Judul Lomba</th>
                            <th class="py-3 px-4 text-center">👁️ Dilihat</th>
                            <th class="py-3 px-4 text-center">🧑‍🎓 Pendaftar</th>
                            <th class="py-3 px-4 text-center">💬 Komentar</th>
                            <th class="py-3 px-4 text-center">⚙️ Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-orange-100 bg-white">
                        @forelse ($lombas as $lomba)
                            <tr class="hover:bg-orange-50 transition">
                                <td class="py-3 px-4 font-medium text-gray-800">{{ $lomba->title }}</td>
                                <td class="py-3 px-4 text-center">
                                    <span class="bg-indigo-100 text-indigo-800 text-xs font-semibold px-3 py-1 rounded-full">
                                        {{ $lomba->view_count }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 text-center">
                                    <span class="bg-green-100 text-green-800 text-xs font-semibold px-3 py-1 rounded-full">
                                        {{ $lomba->pendaftarans_count }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 text-center">
                                    <span class="bg-yellow-100 text-yellow-800 text-xs font-semibold px-3 py-1 rounded-full">
                                        {{ $lomba->comments_count }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 text-center">
                                    <a href="{{ route('admin.lomba.pendaftar', $lomba->id) }}"
                                        class="inline-flex items-center bg-blue-500 hover:bg-blue-600 text-white text-xs font-medium px-3 py-1 rounded-full transition shadow">
                                        🔍 Lihat Pendaftar
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-6 text-gray-500">
                                    ⚠️ Belum ada lomba yang dibuat.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
