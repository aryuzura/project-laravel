<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $table = 'comments';

    protected $fillable = ['comment', 'user_id', 'lomba_id'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function lomba() {
        return $this->belongsTo(Lomba::class);
    }
}
