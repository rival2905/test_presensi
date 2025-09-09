<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MainCategory extends Model
{
    use HasFactory;

    protected $primaryKey = 'main_category_id';

    protected $fillable = ['name'];

    public function subcategories() {
        return $this->hasMany(SubCategory::class, 'main_category_id');
    }
}

