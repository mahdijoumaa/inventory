<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    //
      protected $fillable = [
        'purchase_no',
        'supplier_id',
        'total_amount',
        'paid_amount',
        'due_amount',
    ];
}
