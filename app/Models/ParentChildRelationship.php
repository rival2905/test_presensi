<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class ParentChildRelationship extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $primaryKey = null;
    public $incrementing = false;

    protected $fillable = ['parent_user_id','child_user_id','relationship_type'];

    public function parent() {
        return $this->belongsTo(User::class, 'parent_user_id');
    }

    public function child() {
        return $this->belongsTo(User::class, 'child_user_id');
    }
}
