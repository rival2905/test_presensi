<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Posts;
use App\Models\Notifications;
use App\Models\Messages;
use App\Models\Comments;
use App\Models\Submissions;
use App\Models\Threads;
use App\Models\Replies;



class User1 extends Authenticatable {
    use HasFactory;
    protected $primaryKey = 'user_id';
    protected $fillable = ['full_name','email'];

    // Posts
    public function posts() {
        return $this->hasMany(Posts::class, 'user_id', 'id');
    }

    // Comments
    public function comments() {
        return $this->hasMany(Comments::class, 'user_id', 'id');
    }


    // Notifications
    public function notifications() {
        return $this->hasMany(Notifications::class, 'user_id', 'id');
    }

    // Messages
    public function messages() {
        return $this->hasMany(Messages::class, 'sender_id', 'id');
    }

    // Submissions
    public function submissions() {
        return $this->hasMany(Submissions::class, 'user_id', 'id');
    }

    // Threads
    public function threads() {
        return $this->hasMany(Threads::class, 'user_id', 'id');
    }

    // Replies
    public function replies() {
        return $this->hasMany(Replies::class, 'user_id', 'id');
    }

}

