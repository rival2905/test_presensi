<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Organizations;
use App\Models\Threads;

class Forums extends Model {
    protected $primaryKey = 'forum_id';
    protected $fillable = ['organization_id','title','description'];

    public function organization() {
        return $this->belongsTo(Organizations::class, 'organization_id', 'organization_id');
    }

    public function threads() {
        return $this->hasMany(Threads::class, 'forum_id', 'forum_id');
    }
}

