<?php

// app/Models/Group.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Groups extends Model {
    protected $primaryKey = 'group_id';
    protected $fillable = ['organization_id','name','type'];
}

