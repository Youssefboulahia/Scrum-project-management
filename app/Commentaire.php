<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Commentaire extends Model
{
    protected $table = 'commentaire' ;

    public function developer()
    {
        return $this->belongsTo('App\User', 'writer_id');
    }
}
