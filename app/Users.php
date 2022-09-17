<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Adfood_customer;
use App\Adfood_merchant;
use App\Adfood_food;
use App\Adfood_reservation;
use App\Coolze_partner;
use App\Coolze_driver;
use Illuminate\Database\Eloquent\SoftDeletes;

class Users extends Model
{
    // use SoftDeletes;

    protected $fillable = [        
        'foto','name' ,'email','email_verified_at','isVerified','password','phone','gender','day_of_birth','roles','customers_id','merchants_id','status','order'
    ];

    protected $hidden = [ 
    
    ];

    public function favorite_merchant()
    {
        return $this->hasMany(Favorite::class, 'merchants_id','id'); 
    }
    public function favorite_customer()
    {
        return $this->hasMany(Favorite::class, 'customers_id','id'); 
    }
    public function voucher()
    {
        return $this->hasMany(Coolze_voucher::class, 'merchants_id','id');
    }
    public function promotion()
    {
        return $this->hasMany(Adfood_ori_vouchers::class, 'merchants_id','id');
    }
    public function gallerymerchant()
    {
        return $this->hasMany(Adfood_galleries_merchant::class, 'adfood_merchants_id','id');
    }
    public function customer()
    {
        return $this->belongsTo(Adfood_customer::class, 'customers_id','id'); //dari tabel parent to child 
    }

    public function service()
    {
        return $this->hasMany(Service::class, 'users_id','id'); //dari tabel parent to child 
    }

    public function merchant()
    {
        return $this->belongsTo(Adfood_merchant::class, 'merchants_id','id'); //dari tabel parent to child 
    }
    public function food()
    {
        return $this->hasMany(Adfood_food::class, 'merchants_id','id'); //dari tabel parent to child 
    }
    public function reservation_merchant()
    {
        return $this->hasMany(Adfood_reservation::class,'adfood_merchants_id','merchants_id'); 
    }
    public function reservation_customer()
    {
        return $this->hasMany(User::class, 'adfood_customers_id', 'customers_id'); 
    }





    public function partner()
    {
        return $this->belongsTo(Coolze_partner::class, 'partners_id','id'); //dari tabel parent to child 
    }
    public function driver()//relasi user ke driver dimana user.partners_id = driver.partners_id dimodel users
    {
        return $this->belongsTo(Coolze_driver::class, 'drivers_id','id'); //dari tabel parent to child 
    }
    public function address()//relasi user ke driver dimana user.partners_id = driver.partners_id dimodel users
    {
        return $this->hasMany(Coolze_address::class, 'partners_id','partners_id'); //dari tabel parent to child 
    }
    public function address_cust()//relasi user ke driver dimana user.partners_id = driver.partners_id dimodel users
    {
        return $this->hasMany(Coolze_address::class, 'customers_id','customers_id'); //dari tabel parent to child 
    }
    public function address_mitra()//relasi user ke driver dimana user.partners_id = driver.partners_id dimodel users
    {
        return $this->hasMany(Coolze_address::class, 'partners_id','partners_id'); //dari tabel parent to child 
    }
    // public function partner2()
    // {
    //     return $this->belongsTo(Coolze_partner::class, 'partners_id','id'); //dari tabel parent to child 
    // }
    public function order_cust()
    {
        return $this->hasMany(Coolze_order::class, 'customers_id','customers_id'); //dari tabel parent to child 
    }
    public function order_part()
    {
        return $this->hasMany(Coolze_order::class, 'partners_id','partners_id'); //dari tabel parent to child 
    }
    public function order_drive()
    {
        return $this->hasMany(Coolze_order::class, 'drivers_id','drivers_id'); //dari tabel parent to child 
    }
    // public function customer()
    // {
    //     return $this->belongsTo(Customer::class, 'customers_id', 'id');
    // }

    // public function doctor()
    // {
    //     return $this->belongsTo(Doctor::class, 'doctors_id', 'id');
    // }

    // public function groomer()
    // {
    //     return $this->belongsTo(Groomer::class, 'groomers_id', 'id');
    // }

    public function user()
    {
        return $this->belongsTo(User::class,'customers_id', 'id'); //dari tabel parent to child 
    }
}
