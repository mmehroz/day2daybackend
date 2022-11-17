<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Slider extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'slider_name',
        'slider_title',
        'slider_link',
        'slider_type',
        'slider_description',
        'slider_image',
        'slider_status',
    ];
}
