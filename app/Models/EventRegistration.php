<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EventRegistration extends Model
{
    use HasFactory;

    protected $primaryKey = 'registration_id';

    protected $fillable = ['user_id','schedule_id','status','team_name'];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function schedule() {
        return $this->belongsTo(EventSchedule::class, 'schedule_id');
    }

    public function payment() {
        return $this->hasOne(Payment::class, 'registration_id');
    }
}

