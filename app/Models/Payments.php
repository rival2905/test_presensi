<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payments extends Model {
    protected $primaryKey = 'payment_id';
    protected $fillable = ['registration_id','amount','payment_method','status'];
}

