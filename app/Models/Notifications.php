<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User1;

class Notifications extends Model {
    protected $primaryKey = 'notification_id';
    public $timestamps = false;
    protected $fillable = ['user_id','message','is_read','timestamp'];

    public function user() {
        return $this->belongsTo(User1::class, 'user_id', 'id');
    }
}

