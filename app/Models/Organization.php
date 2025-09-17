<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Organization extends Model
{
    use HasFactory;

    protected $table = 'organizations';
    protected $primaryKey = 'organization_id';
    public $timestamps = true;

    protected $fillable = [
        'parent_organization_id',
        'name',
        'address',
        'contact',
        'logo_url',
    ];

    // Relasi ke parent organization
    public function parent()
    {
        return $this->belongsTo(Organization::class, 'parent_organization_id');
    }

    // Relasi ke child organizations
    public function children()
    {
        return $this->hasMany(Organization::class, 'parent_organization_id');
    }

    // Relasi ke groups
    public function groups()
    {
        return $this->hasMany(Group::class, 'organization_id');
    }

    // Relasi ke affiliations (polymorphic)
    public function affiliations()
    {
        return $this->morphMany(Affiliation::class, 'entity');
    }
}
