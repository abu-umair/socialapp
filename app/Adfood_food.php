<?php

namespace App;

use App\Http\Controllers\Admin\Orivoucher_adfoodController;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Adfood_food extends Model
{
    // use SoftDeletes;

    protected $fillable = [
        'foto','name','categories_id','price', 'promo','status','merchants_id','order','ori_vouchers_id'
    ];

    protected $hidden =[

    ];


    public function category()
    {
        return $this->belongsTo(Adfood_category::class, 'categories_id','id');
    }

    public function gallery()
    {
        return $this->hasMany(Adfood_galleries_food::class, 'adfood_foods_id','id');
    }
    public function merchant_lengkap()
    {
        return $this->hasMany(Adfood_merchant::class, 'id','merchants_id');
    }
    public function merchant()
    {
        return $this->belongsTo(Users::class, 'merchants_id','id');
    }
    public function promotion()
    {
        return $this->belongsTo(Adfood_ori_vouchers::class, 'ori_vouchers_id','id');
    }
    



    

    public function order()
    {
        return $this->hasMany(Coolze_order::class, 'partners_id','id');
    }
    
    
    
    // public function doctors_id()
    // {
    //     return $this->belongsTo(Doctor::class, 'id', 'doctors_id'); //dari tabel parent to child 
    // }
    // public function groomers_id()
    // {
    //     return $this->belongsTo(Groomer::class, 'id', 'groomers_id'); //dari tabel parent to child 
    // }

    public function groomer()
    {
        return $this->belongsTo(Groomer::class, 'groomers_id', 'id');
    }
}
