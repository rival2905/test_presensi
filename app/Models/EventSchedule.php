<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EventSchedule extends Model
{
    use HasFactory;

    protected $primaryKey = 'schedule_id';

    protected $fillable = ['event_id','start_time','end_time','price','quota'];

    public function event() {
        return $this->belongsTo(Event::class, 'event_id');
    }

    public function registrations() {
        return $this->hasMany(EventRegistration::class, 'schedule_id');
    }
}
