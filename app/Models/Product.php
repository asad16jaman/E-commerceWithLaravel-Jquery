<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        "title",
        "slug",
        "description",
        "price",
        "compare_price",
        "catagory_id",
        "sub_catagory_id",
        "brand_id",
        "is_featured",
        "sku",
        "barcode",
        "track_qty",
        "qty",
        "status"
    ];

    public function productImages(){
        return $this->hasMany(ProductImage::class);
    }


}
