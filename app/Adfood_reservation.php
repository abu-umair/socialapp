<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable; //untuk notification

class Adfood_reservation extends Model
{
    use Notifiable; //untuk notification
    // use SoftDeletes;

    protected $fillable = [
        'order_id','adfood_merchants_id', 'adfood_customers_id', 'jumlah_orang', 'date', 'time', 'status','acc', 'rate','date_rate', 'ulasan_rate','pothos_coment','tracking_register','tracking_restaurant_check','tracking_confrimed_restaurant','tracking_done'
    ];

    protected $hidden =[

    ];

    public function merchant()
    {
        return $this->hasMany(User::class, 'merchants_id','adfood_merchants_id'); 
    }
    public function merchant_lengkap()
    {
        return $this->belongsTo(Adfood_merchant::class,'adfood_merchants_id', 'id'); 
    }
    public function customer()
    {
        return $this->hasMany(User::class, 'customers_id','adfood_customers_id'); 
    }
    public function customer_lengkap()
    {
        return $this->belongsTo(Adfood_customer::class,'adfood_customers_id', 'id'); 
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
