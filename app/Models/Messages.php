<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Messages extends Model {
    protected $primaryKey = 'message_id';
    public $timestamps = false;
    protected $fillable = ['sender_id','receiver_id','content','timestamp'];
}

