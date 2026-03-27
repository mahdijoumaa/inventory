<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;



use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Category extends Model
{
    //
  
    protected $fillable = [
        'cat_name',
        'cat_image'
   
    ];
}
