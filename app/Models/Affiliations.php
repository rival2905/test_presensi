<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Affiliations extends Model {
    protected $primaryKey = 'affiliation_id';
    protected $fillable = ['user_id','role_id','entity_id','entity_type'];
}

