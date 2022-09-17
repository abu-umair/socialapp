<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Adfood_category extends Model
{
    // use SoftDeletes;

    protected $fillable = [
        'id','foto','category',
    ];

    protected $hidden =[

    ];

    public function food()
    {
        return $this->hasMany(Adfood_food::class, 'categories_id','id');
    }
}
