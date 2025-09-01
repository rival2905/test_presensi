<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Organizations;
use App\Models\Submissions;

class Tasks extends Model {
    protected $primaryKey = 'task_id';
    protected $fillable = ['organization_id','title','description','due_date'];

     public function organization() {
        return $this->belongsTo(Organizations::class, 'organization_id', 'organization_id');
    }

    public function submissions() {
        return $this->hasMany(Submissions::class, 'task_id', 'task_id');
    }
}

