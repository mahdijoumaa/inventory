<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    //

    protected $fillable = [
    'cust_name',
    'cust_email',
    'cust_phone',
    'cust_address',
    'cust_image',
];
}
