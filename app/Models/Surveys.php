<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Surveys extends Model {
    protected $primaryKey = 'survey_id';
    protected $fillable = ['organization_id','title','description'];
}

