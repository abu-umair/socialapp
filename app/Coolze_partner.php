<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coolze_partner extends Model
{
    // use SoftDeletes;

    protected $fillable = [
        'id', 'reveral',
    ];

    protected $hidden =[

    ];

    public function user()
    {
        return $this->hasMany(User::class, 'partners_id','id'); //dari tabel parent to child 
    }
    public function driver()
    {
        return $this->hasMany(Coolze_driver::class, 'partners_id','id'); //dari tabel parent to child 
    }
    
    // public function partner()
    // {
    //     return $this->belongsTo(Partner::class, 'partners_id', 'id');
    // }
    

    // public function groomer()
    // {
    //     return $this->belongsTo(Groomer::class, 'groomers_id', 'id');
    // }
}
