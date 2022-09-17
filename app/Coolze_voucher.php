<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coolze_voucher extends Model
{
    // use SoftDeletes;

    protected $fillable = [
        'name','price','expired_at','expired_at_time','home','voucher','used','status','type','coupon_code','min_purchase','description','discount','merchants_id'
    ];

    protected $hidden =[

    ];

    public function gallery()
    {
        return $this->hasMany(Adfood_galleries_voucher::class, 'vouchers_id','id');
    }

    public function merchant()
    {
        return $this->belongsTo(Users::class, 'merchants_id','id');
    }

    
}
