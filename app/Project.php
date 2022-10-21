<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $table = 'projects' ;


    public function projectDevelopers() {
        return $this->belongsToMany('App\User', 'project_developer', 'project_id', 'developer_id');
      }

    public function productOwner()
    {
        return $this->belongsTo('App\User','id_productOwner');
    }
}
