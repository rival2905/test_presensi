<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Group extends Model
{
    use HasFactory;

    protected $primaryKey = 'group_id';

    public function organization() {
        return $this->belongsTo(Organization::class, 'organization_id');
    }

    public function activities() {
        return $this->hasMany(Activity::class, 'group_id');
    }

    public function events() {
        return $this->hasMany(Event::class, 'host_group_id');
    }

    public function affiliations() {
        return $this->morphMany(Affiliation::class, 'entity');
    }

    public function categories() {
        return $this->belongsToMany(SubCategory::class, 'group_categories', 'group_id', 'subcategory_id');
    }

    public function media() {
        return $this->hasMany(Media::class, 'group_id');
    }
}

