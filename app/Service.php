<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    // use SoftDeletes;

    protected $fillable = [        
        'users_id',
        'price',
        'title',
        'desc',
    ];

    protected $hidden = [ 
    
    ];

    public function customer()
    {
        return $this->belongsTo(Adfood_customer::class, 'users_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(Users::class, 'users_id', 'id');
    }

    // public function doctor()
    // {
    //     return $this->belongsTo(Doctor::class, 'doctors_id', 'id');
    // }

    // public function groomer()
    // {
    //     return $this->belongsTo(Groomer::class, 'groomers_id', 'id');
    // }

    // public function user()
    // {
    //     return $this->belongsTo(User::class,'customers_id', 'id'); //dari tabel parent to child 
    // }
}
