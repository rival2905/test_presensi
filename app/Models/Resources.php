<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Organizations;

class Resources extends Model {
    protected $primaryKey = 'resource_id';
    protected $fillable = ['organization_id','title','description','url'];

     public function organization() {
        return $this->belongsTo(Organizations::class, 'organization_id', 'organization_id');
    }
}

