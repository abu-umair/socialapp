<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coolze_address extends Model
{
    // use SoftDeletes;

    protected $fillable = [
        'customers_id', 'partners_id','address','long','lat','alamat_utama',
    ];

    protected $hidden =[

    ];

    public function partner()
    {
        return $this->belongsTo(User::class, 'partners_id','partners_id'); //dari tabel parent to child 
    }
    public function customer()
    {
        return $this->belongsTo(User::class, 'customers_id','customers_id'); //dari tabel parent to child 
    }
    
}
