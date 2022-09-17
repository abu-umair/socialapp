<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Adfood_stripe extends Model
{
    // use SoftDeletes;

    protected $fillable = [
        'card_information',
        'date',
        'cvc',
        'country_region',
        'zip',
        'created',
        'id_card',
        'livemode',
        'type',
        'addressLine1',
        'addressLine2',
        'brand',
        'expMonth',
        'expYear',
        'funding',
        'last4',
        'number',
        'token',
        'id_paymentmethod',
        'merchants_id',
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

    
}
