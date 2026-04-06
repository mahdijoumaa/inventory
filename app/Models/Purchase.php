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

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function metas()
    {
        return $this->hasMany(PurchaseMeta::class, 'purchase_id');
    }
}
