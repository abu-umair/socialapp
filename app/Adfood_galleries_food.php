<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Adfood_galleries_food extends Model
{
    // use SoftDeletes;

    protected $fillable = [
        'name','adfood_foods_id','foto','urutan'
    ];

    protected $hidden =[

    ];

    public function food()
    {
        return $this->belongsTo(Adfood_food::class, 'adfood_foods_id','id');
    }
    public function merchant()
    {
        return $this->hasMany(Adfood_merchant::class, 'id','merchants_id');
    }
    public function user()
    {
        return $this->hasMany(Users::class, 'id','merchants_id');
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
