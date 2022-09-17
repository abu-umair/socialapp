<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Favorite extends Model
{
    // use SoftDeletes;

    protected $fillable = [
        'id','customers_id','merchants_id',
    ];

    protected $hidden =[

    ];

    public function merchant()
    {
        return $this->belongsTo(Users::class, 'merchants_id','id'); 
    }
    public function merchant_lengkap()
    {
        return $this->belongsTo(Adfood_merchant::class, 'merchants_id','id'); 
    }
    public function gallerymerchant()
    {
        return $this->hasMany(Adfood_galleries_merchant::class, 'adfood_merchants_id','merchants_id');
    }
    public function customer()
    {
        return $this->belongsTo(Users::class, 'customers_id','id'); 
    }
    public function customer_lengkap()
    {
        return $this->belongsTo(Adfood_customer::class, 'customers_id','id'); 
    }
}
