<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DynamicField extends Model
{
    // use SoftDeletes;

    protected $fillable = [
        'first_name',
        // 'last_name',
    ];

    protected $hidden =[

    ];

    public function service()
    {
        return $this->belongsTo(Service::class,'layanan', 'id');//dari tabel child to parent
    }
}
