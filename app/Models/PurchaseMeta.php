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
}
