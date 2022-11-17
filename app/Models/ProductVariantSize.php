<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductVariantSize extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable =[
        'product_id',
        'variant_id',
        'size',
        'quantity',
    ];
}
