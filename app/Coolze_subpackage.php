<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coolze_subpackage extends Model
{
    // use SoftDeletes;

    protected $fillable = [
        
       'packages_id','deskripsi_title','price_dasar','price_diskon'
    ];

    protected $hidden =[

    ];

    public function subpackage()
    {
        return $this->belongsTo(Coolze_package::class, 'packages_id','id'); //dari tabel parent to child 
    }
}
