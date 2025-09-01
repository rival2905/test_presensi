<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Likes extends Model {
    protected $primaryKey = 'like_id';
    public $timestamps = false;
    protected $fillable = ['post_id','user_id','timestamp'];
}

