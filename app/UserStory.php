<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserStory extends Model
{
    protected $table = 'userstories';

    public function developer()
    {
        return $this->belongsTo('App\User', 'developer_id');
    }

    public function project()
    {
        return $this->belongsTo('App\Project', 'project_id');
    }

    public function sprint()
    {
        return $this->belongsTo('App\Sprint', 'sprint_id');
    }
}
