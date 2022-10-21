<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'message' ;

    public function developer()
    {
        return $this->belongsTo('App\User','writer_id');
    }
}
