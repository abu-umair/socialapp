<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Adfood_subscription extends Model
{
    // use SoftDeletes;

    protected $fillable = [
        'category',
        'foto',
        'price',
        'price_discount',
        'extra_posts',
        'extra_images',
        'weeks',
        'start_date',
        'expired_date',
        'status',
        
    ];

    protected $hidden =[

    ];

    

    
}
