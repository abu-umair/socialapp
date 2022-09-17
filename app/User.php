<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Adfood_customer;
use App\Adfood_merchant;
use App\Adfood_food;
use App\Coolze_partner;
use App\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Claims\Custom;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject, MustVerifyEmail
{
    use Notifiable; //untuk notification

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'foto','name', 'email', 'password','isVerified','phone','gender','day_of_birth','customers_id','roles', 'merchants_id','status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }


    // public function customers_id()
    // {
    //     return $this->hasMany(Customer::class, 'id','customers_id'); //dari tabel parent to child 
    // }
    // public function doctors_id()
    // {
    //     return $this->hasMany(Doctor::class, 'id', 'doctors_id'); //dari tabel parent to child 
    // }
    // public function groomers_id()
    // {
    //     return $this->hasMany(Groomer::class, 'id', 'groomers_id'); //dari tabel parent to child 
    // }
    
    // public function customer()
    // {
    //     return $this->belongsTo(Adfood_customer::class, 'customers_id','id'); //dari tabel parent to child 
    // }
    // public function merchant()
    // {
    //     return $this->belongsTo(Adfood_merchant::class, 'merchants_id','id'); //dari tabel parent to child 
    // }
    // public function food()
    // {
    //     return $this->belongsTo(Adfood_food::class, 'merchants_id','id'); //dari tabel parent to child 
    // }
    
    
    public function token()
    {
        return $this->belongsTo(Otpcustom::class, 'id','users_id'); //dari tabel parent to child 
    }
    
    public function customer()
    {
        return $this->belongsTo(Adfood_customer::class, 'customers_id','id'); //dari tabel parent to child 
    }
    public function merchant()
    {
        return $this->belongsTo(Adfood_merchant::class, 'merchants_id','id'); //dari tabel parent to child 
    }
    public function partner()
    {
        return $this->belongsTo(Coolze_partner::class, 'partners_id','id'); //dari tabel parent to child 
    }
    public function driverBelongsToPartner()//relasi user ke driver dimana user.partners_id = driver.partners_id dimodel users
    {
        return $this->belongsTo(Coolze_driver::class, 'partners_id','partners_id'); //dari tabel parent to child 
    }
    
    public function address()
    {
        return $this->hasMany(User::class, 'customers_id','customers_id'); //dari tabel parent to child 
    }

    
}
