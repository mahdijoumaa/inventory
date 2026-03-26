<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    //
  protected $fillable = [
        'supp_name',
        'supp_email',
        'supp_phone',
        'supp_address',
        'supp_image',
    ];
}
