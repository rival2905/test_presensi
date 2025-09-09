<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

// model
class Payment extends Model
{
    use HasFactory;

    protected $primaryKey = 'payment_id';

    protected $fillable = ['registration_id','amount','payment_method','status','paid_at'];

    public function registration() {
        return $this->belongsTo(EventRegistration::class, 'registration_id');
    }
}

