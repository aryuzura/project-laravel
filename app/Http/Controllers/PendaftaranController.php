<?php

namespace App\Http\Controllers;

use App\Models\Lomba;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PendaftaranController extends Controller
{
    public function store(Request $request, Lomba $lomba)
    {
        $user = Auth::user();

        // Cek apakah data diri lengkap
        if (empty($user->kelas) || empty($user->asal_kampus)) {
            return redirect()->route('mahasiswa.profile.edit')->with('error', 'Lengkapi data diri Anda (kelas dan asal kampus) sebelum mendaftar.');
        }

        // Cek duplikasi
        $existing = Pendaftaran::where('user_id', $user->id)
                                ->where('lomba_id', $lomba->id)
                                ->first();

        if ($existing) {
            return back()->with('error', 'Anda sudah terdaftar pada lomba ini.');
        }

        Pendaftaran::create([
            'user_id' => $user->id,
            'lomba_id' => $lomba->id,
        ]);

        return redirect()->route('lombas.show', $lomba->id)->with('success', 'Berhasil mendaftar lomba!');
    }
}