<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Adfood_merchant extends Model
{
    // use SoftDeletes;

    protected $fillable = [
        'id','min_price','max_price','about','open_restaurant', 'close_restaurant','website', 'address', 'long', 'lat','type_business','phone_restaurant'
    ];

    protected $hidden =[

    ];

    
    public function favorite()
    {
        return $this->hasMany(Favorite::class, 'merchants_id','id'); 
    }

    public function user()
    {
        return $this->hasMany(User::class, 'merchants_id','id');
    }

    public function food()
    {
        return $this->belongsTo(Adfood_food::class, 'merchants_id','id');
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
