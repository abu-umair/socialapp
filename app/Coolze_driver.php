<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coolze_driver extends Model
{
    // use SoftDeletes;

    protected $fillable = [
        'id','partners_id','file','file_name','name','no_anggota','tarif','long','lat','alamat','confirm'
    ];

    protected $hidden =[

    ];

    public function partner()
    {
        return $this->belongsTo(Coolze_partner::class, 'partners_id','id'); //dari tabel parent to child 
    }
    public function partner_lengkap()
    {
        return $this->belongsTo(User::class, 'partners_id','partners_id'); //dari tabel parent to child 
    }
    public function order()
    {
        return $this->hasMany(Coolze_order::class, 'drivers_id','id'); //dari tabel parent to child 
    }
    public function driver_lengkap()
    {
        return $this->hasMany(User::class,'drivers_id', 'id'); //dari tabel parent to child 
    }
    // public function user() {
    //     return $this->belongsTo(User::class);
    // }
}
