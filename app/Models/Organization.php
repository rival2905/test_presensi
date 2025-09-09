<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

// model
class Organization extends Model
{
    use HasFactory;

    protected $primaryKey = 'organization_id';

    public function parent() {
        return $this->belongsTo(Organization::class, 'parent_organization_id');
    }

    public function children() {
        return $this->hasMany(Organization::class, 'parent_organization_id');
    }

    public function groups() {
        return $this->hasMany(Group::class, 'organization_id');
    }

    public function affiliations() {
        return $this->morphMany(Affiliation::class, 'entity');
    }
}
