<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Otpcustom extends Model
{
    protected $table = "otps";

    protected $fillable = [
        'token','users_id',
    ];

    protected $hidden =[

    ];
}
