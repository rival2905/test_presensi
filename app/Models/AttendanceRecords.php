<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Events;
use App\Models\User1;

class AttendanceRecords extends Model {
    protected $primaryKey = 'attendance_id';
    protected $fillable = ['user_id','event_id','check_in_time','check_out_time'];

    public function event() {
        return $this->belongsTo(Events::class, 'event_id', 'event_id');
    }

    public function user() {
        return $this->belongsTo(User1::class, 'user_id', 'id');
    }
}

