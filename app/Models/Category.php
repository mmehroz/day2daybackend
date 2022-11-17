<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'category_name',
        'category_slug',
        'category_icon',
        'category_image'
    ];

    public function subcategory()
    {
        return $this->hasMany(SubCategory::class, 'category_id', 'id');
    }

    public function subsubcategory()
    {
        return $this->hasMany(SubSubCategory::class, 'category_id', 'id');
    }

    public function products(){
        return $this->hasMany(Product::class,'category_id','id');
    }
}
