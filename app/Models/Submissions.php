<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Tasks;
use App\Models\User1;

class Submissions extends Model {
    protected $primaryKey = 'submission_id';
    protected $fillable = ['task_id','user_id','content','submitted_at'];

    public function task() {
        return $this->belongsTo(Tasks::class, 'task_id', 'task_id');
    }

    public function user() {
        return $this->belongsTo(User1::class, 'user_id', 'id');
    }
}

