<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AttendanceRecord extends Model
{
    use HasFactory;

    protected $primaryKey = 'record_id';
    public $timestamps = false;

    protected $fillable = [
        'activity_id','user_id','photo_url','latitude','longitude',
        'status','reason','attachment_url','timestamp'
    ];

    public function activity() {
        return $this->belongsTo(Activity::class, 'activity_id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
