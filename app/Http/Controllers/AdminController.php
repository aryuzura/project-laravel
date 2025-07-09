<?php

namespace App\Http\Controllers;

use App\Models\Lomba;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;


class AdminController extends Controller
{
    public function dashboard()
    {
        $lombas = Lomba::withCount(['pendaftarans', 'comments'])
                        ->with('user')
                        ->latest()
                        ->get();
                        
        return view('admin.dashboard', compact('lombas'));
    }

    public function pendaftarLomba(Lomba $lomba)
    {
        $pendaftar = $lomba->pendaftarans()->with('user')->get();
        return view('admin.pendaftar', compact('lomba', 'pendaftar'));
    }

    public function updatePendaftaranStatus(Request $request, Pendaftaran $pendaftaran)
    {
        $request->validate([
            'status' => 'required|in:menunggu konfirmasi,dikonfirmasi,selesai,ditolak',
        ]);

        $pendaftaran->status = $request->status;
        $pendaftaran->save();

        return back()->with('success', 'Status pendaftaran berhasil diperbarui!');
    }
}