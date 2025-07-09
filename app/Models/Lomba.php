<?php

namespace App\Models;

use App\Models\Pendaftaran;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lomba extends Model
{
    use HasFactory;
    
    protected $table = 'lombas';

    protected $fillable = ['title', 'content', 'image', 'view_count']; // Tambahkan view_count

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments() {
        return $this->hasMany(Comment::class);
    }

    // Relasi baru
    public function pendaftarans() {
        return $this->hasMany(Pendaftaran::class);
    }
}