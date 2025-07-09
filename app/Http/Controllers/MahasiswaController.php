<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class MahasiswaController extends Controller
{
    public function riwayatLomba()
    {
        $user = Auth::user();
        $pendaftarans = $user->pendaftarans()->with('lomba')->latest()->get();

        return view('mahasiswa.riwayat', compact('pendaftarans'));
    }
    
    public function editProfile()
    {
        $user = Auth::user();
        return view('mahasiswa.profile', compact('user'));
    }
    
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'kelas' => 'required|string|max:255',
            'asal_kampus' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6|confirmed',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->kelas = $request->kelas;
        $user->asal_kampus = $request->asal_kampus;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('mahasiswa.profile.edit')->with('success', 'Profil berhasil diperbarui!');
    }
}