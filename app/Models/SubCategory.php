<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubCategory extends Model
{
    use HasFactory;

    use SoftDeletes;
    protected $fillable = [
        "subcategory_name",
        "subcategory_slug",
        "category_id"
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subsubcategory()
    {
        return $this->hasMany(SubSubCategory::class,'subcategory_id', 'id');
    }

    public function products(){
        return $this->hasMany(Product::class,'subcategory_id','id');
    }
}
