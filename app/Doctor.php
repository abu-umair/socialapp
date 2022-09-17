<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Doctor extends Model
{
    // use SoftDeletes;

    protected $fillable = [
        'foto','name', 'kategori', 'lokasi','lat','long', 'transaksi','layanan', 'status', 'harga', 'pengalaman','jangka','tentang'
    ];

    protected $hidden =[

    ];

    public function service_doctor()
    {
        return $this->hasMany(Service::class,'partners_id', 'id')->where('partners','D');//dari tabel child to parent
    }
    
}
