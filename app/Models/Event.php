<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory;

    protected $primaryKey = 'event_id';

    protected $fillable = [
        'parent_event_id','host_group_id','title','description',
        'location','banner_url','start_date','end_date'
    ];

    public function parent() {
        return $this->belongsTo(Event::class, 'parent_event_id');
    }

    public function children() {
        return $this->hasMany(Event::class, 'parent_event_id');
    }

    public function group() {
        return $this->belongsTo(Group::class, 'host_group_id');
    }

    public function schedules() {
        return $this->hasMany(EventSchedule::class, 'event_id');
    }
}

