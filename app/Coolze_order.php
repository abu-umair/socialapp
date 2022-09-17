<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable; //untuk notification
use Illuminate\Database\Eloquent\SoftDeletes;

class Coolze_order extends Model
{
    use Notifiable; //untuk notification
    // use SoftDeletes;

    protected $fillable = [
        'id_unique',
        'customers_id',
        'partners_id',
        'drivers_id',
        'vouchers_id',
        'packages_id',
        'subpackages_id',
        'merk',
        'qty',
        'date',
        'end_date',
        'time',
        'status',
        'acc',
        'rate',
        'ulasan_rate',
        'isreviewed',
        'created_at',
    ];

    protected $hidden =[

    ];
   
    public function customer()
    {
        return $this->belongsTo(Coolze_customer::class, 'customers_id','id'); //dari tabel parent to child 
    }
    public function user_customer()
    {
        return $this->belongsTo(Users::class, 'customers_id','customers_id'); //dari tabel parent to child 
    }
    public function partner()
    {
        return $this->belongsTo(Coolze_partner::class, 'partners_id','id'); //dari tabel parent to child 
    }
    public function user_partner()
    {
        return $this->belongsTo(Users::class, 'partners_id','partners_id'); //dari tabel parent to child 
    }
    public function alamat_customer()
    {
        return $this->belongsTo(Coolze_address::class, 'customers_id','customers_id')->where('alamat_utama','on'); //dari tabel parent to child 
    }
    public function driver()
    {
        return $this->belongsTo(Users::class, 'drivers_id','drivers_id'); //dari tabel parent to child 
    }
    public function driver_personal()
    {
        return $this->belongsTo(Coolze_driver::class, 'drivers_id','id'); //dari tabel parent to child 
    }
    public function voucher()
    {
        return $this->belongsTo(Coolze_voucher::class, 'vouchers_id','id'); //dari tabel parent to child 
    }
    // public function package()
    // {
    //     return $this->hasManyThrough(Coolze_package::class,Coolze_subpackage::class,'packages_id','id'); //dari tabel parent to child 
    // }
    public function package()
    {
        return $this->belongsTo(Coolze_package::class, 'packages_id','id'); //dari tabel parent to child 
    }
    public function subpackage()
    {
        return $this->belongsTo(Coolze_subpackage::class, 'subpackages_id','id'); //dari tabel parent to child 
    }
}
