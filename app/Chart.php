<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Sprint;

class Chart extends Model
{
    protected $table = 'chart';

    public function sprint()
    {
        return Sprint::find($this->sprint_id);
    }

}
