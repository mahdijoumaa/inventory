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

    // New fields
    'unit',
    'cost_price',
    'sell_price',
    'vat',
    'min_stock',
    'max_stock',
    'is_active',
    'description',
    'barcode',
    'location',
      'expiry_date',

];

protected $casts = [
    'cost_price' => 'decimal:2',
    'sell_price' => 'decimal:2',
    'vat' => 'decimal:2',
    'is_active' => 'boolean',
    'expiry_date' => 'date', // ✅ added
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
