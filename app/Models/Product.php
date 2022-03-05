<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'product_id';
    protected $fillable = [
        'category_id',
        'product_name',
        'product_model',
        'product_company',
        'product_price',
        'product_nature',
        'product_description',
        'product_image',
    ];

    protected $casts = [
        'product_name'=>'array',
        'product_description'=>'array',
        'product_nature'=>'array',
        'product_image'=>'array'
    ];

    public function category()
    {
        return $this->hasOne(Category::class,'category_id','category_id');
    }
}
