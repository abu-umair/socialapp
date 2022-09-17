<?php

namespace App;

use App\Message as AppMessage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Submessage extends Model
{
    // use SoftDeletes;

    protected $fillable = [
        'messages_id',
        'message',
        'answer',
    ];

    protected $hidden =[

    ];

    public function message()
    {
        return $this->belongsTo(Message::class, 'messages_id','id'); //dari tabel parent to child 
    }
}
