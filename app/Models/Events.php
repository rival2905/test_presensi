<?php

// app/Models/Event.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Organizations;
use App\Models\AttendanceRecords;

class Events extends Model {
    protected $primaryKey = 'event_id';
    protected $fillable = ['organization_id','title','description'];

    public function organization() {
        return $this->belongsTo(Organizations::class, 'organization_id', 'organization_id');
    }

    public function attendees() {
        return $this->hasMany(AttendanceRecords::class, 'event_id', 'event_id');
    }
}

