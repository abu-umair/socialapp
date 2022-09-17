<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coolze_wallet extends Model
{
    // use SoftDeletes;

    protected $fillable = [
        'customers_id','partners_id','type','by','total','coolpoin',
    ];

    protected $hidden =[

    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'customers_id','customers_id'); //dari tabel parent to child 
    }

    public function user_partner()
    {
        return $this->belongsTo(User::class, 'partners_id','partners_id'); //dari tabel parent to child 
    }
}
