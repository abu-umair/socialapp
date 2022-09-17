<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coolze_package extends Model
{
    // use SoftDeletes;

    protected $fillable = [
        'title','status'
    ];

    protected $hidden =[

    ];

    public function subpackage()
    {
        return $this->hasMany(Coolze_subpackage::class, 'packages_id','id'); //dari tabel parent to child 
    }
}
