<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Notification;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lomba;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LombaController extends Controller
{
    // Ambil semua Lomba dari database, urutkan dari yang terbaru, dan kirimkan ke view 'admin.index'.
    public function index()
    {
        $lombas = Lomba::latest()->get();
        return view('admin.index', compact('lombas'));
    }

    // Tampilkan form untuk membuat Lomba baru (view 'admin.create').
    public function create()
    {
        return view('admin.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $lombaData = $request->only('title', 'content');

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('lombas', 'public');
            $lombaData['image'] = $imagePath;
        }

        $lomba = $request->user()->lombas()->create($lombaData);

        // Buat notifikasi untuk semua mahasiswa
        $mahasiswas = User::where('role', 'mahasiswa')->get();
        foreach ($mahasiswas as $mahasiswa) {
            Notification::create([
                'user_id' => $mahasiswa->id,
                'message' => 'Lomba baru telah ditambahkan: ' . $lomba->title,
                'link' => route('lombas.show', $lomba->id),
            ]);
        }

        session()->flash('success', 'Lomba berhasil dibuat!');
        return redirect()->route('admin.index');
    }

    // Tampilkan form edit Lomba tertentu (view 'admin.edit') dengan data Lomba yang dipilih.
    public function edit(Lomba $lomba)
    {
        return view('admin.edit', compact('lomba'));
    }

    public function update(Request $request, lomba $lomba)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:20048',
        ]);

        $lombaData = $request->only('title', 'content');

        if ($request->hasFile('image')) {
            if ($lomba->image) {
                Storage::delete('public/' . $lomba->image);
            }

            $imagePath = $request->file('image')->store('lombas', 'public');
            $lombaData['image'] = $imagePath;
        }

        $lomba->update($lombaData);

        session()->flash('success', 'Lomba berhasil diperbarui!');
        return redirect()->route('admin.index');
    }

    // - Hapus gambar terkait jika ada
    // - Hapus data Lomba dari database
    // - Redirect ke route 'admin.index' dengan pesan sukses
    public function destroy(Lomba $lomba)
    {
        if ($lomba->image) {
            Storage::delete('public/' . $lomba->image);
        }

        $lomba->delete();

        session()->flash('success', 'Lomba berhasil dihapus!');
        return redirect()->route('admin.index');
    }

    // - Tampilkan detail Lomba tertentu berdasarkan ID
    // - Sertakan relasi komentar dan user pada komentar
    // - Kirim ke view 'lombas.show'
    public function show($id)
    {
        $lomba = Lomba::with(['comments.user'])->findOrFail($id);

        // Increment view count
        $lomba->increment('view_count');
        
        $isRegistered = false;
        if(Auth::check()) {
            $isRegistered = $lomba->pendaftarans()->where('user_id', Auth::id())->exists();
        }

        return view('lombas.show', compact('lomba', 'isRegistered'));
    }
}
