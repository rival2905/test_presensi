<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventSchedules extends Model {
    protected $primaryKey = 'schedule_id';
    protected $fillable = ['event_id','start_time','end_time','location'];
}

