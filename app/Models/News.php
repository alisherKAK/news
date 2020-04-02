<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $fillable = [
      'title', 'title_img', 'content', 'category_id'
    ];

    function users() {
        return $this->belongsToMany(User::class, 'news_users');
    }

    function comments() {
        return $this->hasMany(Comment::class);
    }

    function getFirstTitleLetters($n) {
        return trim(mb_strtolower(substr($this->title, 0, $n)), " \t\n\r\0\x0B");
    }
}
