<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lomba;
use App\Models\Comment;

class CommentController extends Controller
{
    /**
     * - Validasi input komentar ('comment' wajib diisi dan maksimal 1000 karakter)
     * - Simpan komentar baru pada Lomba tertentu, relasikan dengan user yang sedang login
     * - Tampilkan pesan sukses dan redirect ke halaman detail Lomba
     */
    public function store(Request $request, Lomba $lomba)
    {
        $request->validate([
            'comment' => 'required|max:1000',
        ]);

        $comment = new Comment();
        $comment->comment = $request->comment;
        $comment->user_id = auth()->id();
        $comment->lomba_id = $lomba->id;
        $comment->save();

        session()->flash('success', 'Komentar berhasil ditambahkan!');
        return redirect()->route('lombas.show', $lomba->id);
    }

    public function destroy(Comment $comment) {
        $lombaId = $comment->lomba_id;
        $comment->delete();
    
        session()->flash('success', 'Comment berhasil dihapus!');
        return redirect()->route('lombas.show', ['lomba' => $lombaId]);
    }
}