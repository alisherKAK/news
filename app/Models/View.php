<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class View extends Model
{
    protected $fillable = [
      'client_ip', 'news_id'
    ];
}
