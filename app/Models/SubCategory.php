<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubCategory extends Model
{
    use HasFactory;

    protected $primaryKey = 'subcategory_id';

    protected $fillable = ['main_category_id','name'];

    public function mainCategory() {
        return $this->belongsTo(MainCategory::class, 'main_category_id');
    }

    public function groups() {
        return $this->belongsToMany(Group::class, 'group_categories', 'subcategory_id', 'group_id');
    }
}
