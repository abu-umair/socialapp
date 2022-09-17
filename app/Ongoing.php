<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ongoing extends Model
{
    // use SoftDeletes;

    protected $fillable = [
        'customers_id', 'doctors_id', 'groomers_id', 'date', 'time', 'metode_layanan', 'status', 'time_akhir', 'masalah_hewan', 'acc','id_unique','nilai_product','review_product','isreviewed' 
    ];

    protected $hidden =[

    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customers_id', 'id');
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctors_id', 'id');
    }

    public function groomer()
    {
        return $this->belongsTo(Groomer::class, 'groomers_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'customers_id', 'id'); 
    }
    public function service()
    {
        return $this->belongsTo(Service::class,'metode_layanan', 'id'); 
    }
}
