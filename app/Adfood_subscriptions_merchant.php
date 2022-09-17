<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Adfood_subscriptions_merchant extends Model
{
    // use SoftDeletes;

    protected $fillable = [
        'id','subscriptions_id','merchants_id',
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
    public function subscription()
    {
        return $this->belongsTo(Adfood_subscription::class, 'subscriptions_id','id'); 
    }
    
}
