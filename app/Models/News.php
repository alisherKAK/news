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
}
