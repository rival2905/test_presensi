<?php

// app/Models/EventRegistration.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventRegistrations extends Model {
    protected $primaryKey = 'registration_id';
    protected $fillable = ['event_id','user_id','registration_date'];
}

