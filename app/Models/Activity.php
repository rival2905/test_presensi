<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

// model
class Activity extends Model
{
    use HasFactory;

    protected $primaryKey = 'activity_id';

    protected $fillable = ['group_id','name','description','start_date','end_date'];

    public function group() {
        return $this->belongsTo(Group::class, 'group_id');
    }

    public function attendanceRecords() {
        return $this->hasMany(AttendanceRecord::class, 'activity_id');
    }
}

