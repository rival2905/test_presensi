<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Threads;
use App\Models\User1;

class Replies extends Model {
    protected $primaryKey = 'reply_id';
    protected $fillable = ['thread_id','user_id','content'];

     public function thread() {
        return $this->belongsTo(Threads::class, 'thread_id', 'thread_id');
    }

    public function user() {
        return $this->belongsTo(User1::class, 'user_id', 'id');
    }
}

