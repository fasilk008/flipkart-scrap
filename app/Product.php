<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected  $fillable = ['product_id', 'product_id', 'variant', 'image', 'rating', 'store_price', 'original_price'];
}
