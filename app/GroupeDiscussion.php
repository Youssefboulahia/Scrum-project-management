<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\DiscussionDeveloper;
use App\Message;

class GroupeDiscussion extends Model
{
    protected $table = 'groupediscussion' ;

    public function groupeDevelopers()
    {
        return DiscussionDeveloper::where('groupeDiscussion_id',$this->id)->get();
    }

    public function Messages()
    {
        return Message::where('groupeDiscussion_id', $this->id)->get();
    }
}
