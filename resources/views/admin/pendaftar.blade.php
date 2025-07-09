@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-8">
    <a href="{{ route('admin.index') }}"
            class="inline-flex items-center bg-red-600 text-white font-semibold px-4 py-2 rounded-full shadow hover:bg-red-700 transition mb-6">
            ⬅️ Kembali ke Dashboard
    </a>
    <div class="bg-gradient-to-r from-yellow-400 via-orange-500 to-pink-500 text-white rounded-lg p-6 shadow-lg mb-6">
        <h1 class="text-3xl font-bold">📋 Pendaftar Lomba</h1>
        <p class="mt-1 font-light text-sm">Lomba: <strong>{{ $lomba->title }}</strong></p>
    </div>

    {{-- Alert Message --}}
    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-800 p-4 rounded mb-4 shadow-sm">
            ✅ {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-800 p-4 rounded mb-4 shadow-sm">
            ❌ {{ session('error') }}
        </div>
    @endif

    <div class="bg-white p-6 rounded-xl shadow-lg overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 text-sm text-gray-800">
            <thead class="bg-gray-100 text-gray-700 font-semibold">
                <tr>
                    <th class="py-3 px-4 text-center">No</th>
                    <th class="py-3 px-4 text-left">Nama Mahasiswa</th>
                    <th class="py-3 px-4 text-left">Email</th>
                    <th class="py-3 px-4 text-left">Kelas</th>
                    <th class="py-3 px-4 text-left">Asal Kampus</th>
                    <th class="py-3 px-4 text-left">Tgl Daftar</th>
                    <th class="py-3 px-4 text-center">Status</th>

                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($pendaftar as $index => $item)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="py-3 px-4 text-center font-medium">{{ $index + 1 }}</td>
                        <td class="py-3 px-4">{{ $item->user->name }}</td>
                        <td class="py-3 px-4">{{ $item->user->email }}</td>
                        <td class="py-3 px-4">{{ $item->user->kelas }}</td>
                        <td class="py-3 px-4">{{ $item->user->asal_kampus }}</td>
                        <td class="py-3 px-4">{{ $item->created_at->format('d M Y H:i') }}</td>
                        <td class="py-3 px-4 text-center">
                            <form action="{{ route('admin.pendaftarans.updateStatus', $item->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <select name="status" onchange="this.form.submit()"
                                    class="text-sm px-2 py-1 border rounded-md shadow-sm focus:ring-2 focus:ring-orange-400 focus:outline-none transition
                                        @error('status') border-red-500 @enderror">
                                    <option value="menunggu konfirmasi" {{ $item->status == 'menunggu konfirmasi' ? 'selected' : '' }}>🕐 Menunggu</option>
                                    <option value="dikonfirmasi" {{ $item->status == 'dikonfirmasi' ? 'selected' : '' }}>✅ Dikonfirmasi</option>
                                    <option value="selesai" {{ $item->status == 'selesai' ? 'selected' : '' }}>🏁 Selesai</option>
                                    <option value="ditolak" {{ $item->status == 'ditolak' ? 'selected' : '' }}>❌ Ditolak</option>
                                </select>


                                @error('status')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </form>
                        </td>
                        <td class="py-3 px-4 text-center">
                            {{-- Tombol tambahan bisa diletakkan di sini --}}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-6 text-gray-500 font-medium">
                            ⚠️ Belum ada pendaftar untuk lomba ini.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
