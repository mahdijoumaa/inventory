<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
     protected $fillable = [
        'product_code',
        'product_name',
        'product_image',
        'cat_id',
        'supp_id',
        'brand',
    ];

      // Category relationship
    public function category()
    {
        return $this->belongsTo(Category::class, 'cat_id');
    }

    // Supplier relationship
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supp_id');
    }
}
