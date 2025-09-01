<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Forums;
use App\Models\User1;
use App\Models\Replies;

class Threads extends Model {
    protected $primaryKey = 'thread_id';
    protected $fillable = ['forum_id','user_id','title','content'];

    public function forum() {
        return $this->belongsTo(Forums::class, 'forum_id', 'forum_id');
    }

    public function user() {
        return $this->belongsTo(User1::class, 'user_id', 'id');
    }

    public function replies() {
        return $this->hasMany(Replies::class, 'thread_id', 'thread_id');
    }
}

