@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Riwayat Lomba</h1>
        <a href="{{ route('home') }}"
           class="flex items-center gap-2 bg-red-500 hover:bg-red-600 text-white px-5 py-2 rounded-full transition">
            <span class="material-icons text-sm">arrow_back</span> Kembali
        </a>
    </div>

    @if ($pendaftarans->isEmpty())
        <div class="bg-white rounded-xl shadow-md p-6 text-center text-gray-600">
            <p class="text-lg">Anda belum pernah mendaftar lomba.</p>
        </div>
    @else
        <div class="grid gap-6">
            @foreach ($pendaftarans as $pendaftaran)
                <div class="bg-white shadow-lg rounded-xl p-6 hover:shadow-xl transition duration-300">
                    <div class="flex justify-between items-start">
                        <div>
                            <h2 class="text-xl font-semibold text-gray-800 mb-1">
                                {{ $pendaftaran->lomba->title }}
                            </h2>
                            <p class="text-sm text-gray-500">
                                Terdaftar pada: {{ $pendaftaran->created_at->format('d M Y') }}
                            </p>

                            {{-- Status Pendaftaran --}}
                            <div class="mt-3">
                                @php
                                    $statusColor = match($pendaftaran->status) {
                                        'menunggu konfirmasi' => 'bg-yellow-100 text-yellow-800',
                                        'dikonfirmasi' => 'bg-green-100 text-green-800',
                                        default => 'bg-blue-100 text-blue-800',
                                    };
                                    $statusLabel = ucfirst($pendaftaran->status);
                                @endphp
                                <span class="inline-block text-xs font-bold px-3 py-1 rounded-full {{ $statusColor }}">
                                    {{ $statusLabel }}
                                </span>
                            </div>
                        </div>

                        <a href="{{ route('lombas.show', $pendaftaran->lomba->id) }}"
                           class="text-sm text-blue-600 hover:underline mt-2">
                            Lihat Detail
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
