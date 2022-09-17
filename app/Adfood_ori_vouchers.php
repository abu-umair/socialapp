<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Adfood_ori_vouchers extends Model
{
    // use SoftDeletes;

    protected $fillable = [
        'name',
        'foto',
        'coupon_code',
        'start_date',
        'end_date',
        'min_purchase',
        'description',
        'discount',
        'home',
        'voucher',
        'status',
        'merchants_id'
    ];

    protected $hidden =[

    ];

    public function merchant()
    {
        return $this->belongsTo(Users::class, 'merchants_id','id');
    }
    public function merchant_lengkap()
    {
        return $this->belongsTo(Adfood_merchant::class, 'merchants_id', 'id');
    }

    
}
