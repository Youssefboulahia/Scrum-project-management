<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\GroupeDiscussion;
use App\Sprint;

class Notification extends Model
{
    protected $table = 'notification';

    public function groupe()
    {
        return GroupeDiscussion::where('id',$this->groupe_id)->first();
    }

    public function sprint()
    {
        return Sprint::where('id',$this->sprint_id)->first();
    }

}
