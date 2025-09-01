<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User1;
use App\Models\Comments;

class Posts extends Model {
    protected $primaryKey = 'post_id';
    public $timestamps = false;
    protected $fillable = ['user_id','content','timestamp'];

    public function user() {
        return $this->belongsTo(User1::class, 'user_id', 'id');
    }

    public function comments() {
        return $this->hasMany(Comments::class, 'post_id', 'post_id');
    }
}

