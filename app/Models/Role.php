<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory;

    protected $primaryKey = 'role_id';

    protected $fillable = ['name'];

    public function affiliations() {
        return $this->hasMany(Affiliation::class, 'role_id');
    }
}

