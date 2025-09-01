<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Events;
use App\Models\Resources;
use App\Models\Tasks;
use App\Models\Forums;

class Organizations extends Model {
    protected $primaryKey = 'organization_id';
    protected $fillable = ['parent_organization_id','name'];


    public function events() {
        return $this->hasMany(Events::class, 'organization_id', 'organization_id');
    }

    public function resources() {
        return $this->hasMany(Resources::class, 'organization_id', 'organization_id');
    }


    public function tasks() {
        return $this->hasMany(Tasks::class, 'organization_id', 'organization_id');
    }

    public function forums() {
        return $this->hasMany(Forums::class, 'organization_id', 'organization_id');
    }
}

