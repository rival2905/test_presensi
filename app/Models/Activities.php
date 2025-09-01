<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activities extends Model {
    protected $primaryKey = 'activity_id';
    public $timestamps = false;
    protected $fillable = ['user_id','action','timestamp'];
}

