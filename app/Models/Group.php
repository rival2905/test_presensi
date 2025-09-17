<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Group extends Model
{
    use HasFactory;

    protected $table = 'groups';
    protected $primaryKey = 'group_id';
    public $timestamps = true;

    protected $fillable = [
        'organization_id',
        'name',
        'type',
        'description',
    ];

    // Relasi ke Organization
    public function organization()
    {
        return $this->belongsTo(Organization::class, 'organization_id');
    }

    // Relasi ke Activities
    public function activities()
    {
        return $this->hasMany(Activity::class, 'group_id');
    }

    // Relasi ke Events
    public function events()
    {
        return $this->hasMany(Event::class, 'host_group_id');
    }

    // Relasi polymorphic ke Affiliation
    public function affiliations()
    {
        return $this->morphMany(Affiliation::class, 'entity');
    }

    // Relasi many-to-many ke SubCategory lewat group_categories
    public function categories()
    {
        return $this->belongsToMany(SubCategory::class, 'group_categories', 'group_id', 'subcategory_id');
    }

    // Relasi ke Media
    public function media()
    {
        return $this->hasMany(Media::class, 'group_id');
    }
}
