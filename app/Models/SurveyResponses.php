<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurveyResponses extends Model {
    protected $primaryKey = 'response_id';
    protected $fillable = ['survey_id','user_id','response_text'];
}

