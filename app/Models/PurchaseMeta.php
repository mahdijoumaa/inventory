<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseMeta extends Model
{
    //
      protected $fillable = [
        'purchase_id',
        'category_id',
        'qty',
        'unit_price',
        'unit_id',
    ];

    public function purchase()
{
    return $this->belongsTo(\App\Models\Purchase::class, 'purchase_id');
}

public function category()
{
    return $this->belongsTo(\App\Models\Category::class, 'category_id');
}

public function unit()
{
    return $this->belongsTo(\App\Models\Unit::class, 'unit_id');
}
}
