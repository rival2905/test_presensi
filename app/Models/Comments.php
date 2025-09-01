<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Posts;
use App\Models\User1;

class Comments extends Model {
    protected $primaryKey = 'comment_id';
    public $timestamps = false;
    protected $fillable = ['post_id','user_id','content','timestamp'];

     public function post() {
        return $this->belongsTo(Posts::class, 'post_id', 'post_id');
    }

    public function user() {
        return $this->belongsTo(User1::class, 'user_id', 'id');
    }
}

