<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $fillable = [
        'text',
        'post_title',
        'photo_path',
        'user_id',
    ];
    protected $guarded = ['id'];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
