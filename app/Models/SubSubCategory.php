<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubSubCategory extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $fillable = [
        "subsubcategory_name",
        "subsubcategory_slug",
        "category_id",
        "subcategory_id"
    ];

    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }
    public function subcategory()
    {
        return $this->hasOne(SubCategory::class, 'id', 'subcategory_id');
    }
    public function products(){
        return $this->hasMany(Product::class,'sub_subcategory_id','id');
    }
}
