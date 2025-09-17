<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Media extends Model
{
    use HasFactory;

    protected $primaryKey = 'media_id';
    public $timestamps = false;

    protected $fillable = ['user_id','group_id','file_url','type','mime_type', 'description','uploaded_at'];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function group() {
        return $this->belongsTo(Group::class, 'group_id');
    }
}

