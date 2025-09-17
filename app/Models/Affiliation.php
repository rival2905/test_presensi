<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Affiliation extends Model
{
    use HasFactory;

    protected $primaryKey = 'affiliation_id';

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function entity() {
        return $this->morphTo(__FUNCTION__, 'entity_type', 'entity_id');
    }
}

