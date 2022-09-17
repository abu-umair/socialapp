<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coolze_withdraw extends Model
{
    // use SoftDeletes;

    protected $fillable = [
        'partners_id','id_withdraw','bukti_tf','nominal','norek','bank_tujuan'
    ];

    protected $hidden =[

    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'partners_id','partners_id'); //dari tabel parent to child 
    }
}
