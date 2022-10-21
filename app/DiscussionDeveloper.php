<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Profile;

class DiscussionDeveloper extends Model
{
    protected $table = 'groupediscussion_developer' ;

    public function profile()
    {
        return Profile::where('user_id',$this->developer_id)->first();
    }
    public function developer()
    {
        return $this->belongsTo('App\User','developer_id');
    }

    public function groupesDiscussion()
    {
        return GroupeDiscussion::all()->where('id',$this->groupeDiscussion_id)->all();
    }

}
