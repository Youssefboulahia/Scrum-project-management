<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sprint extends Model
{
    protected $table = 'sprint' ;

    public function userStories()
    {
        return $this->hasMany('App\UserStory', 'sprint_id');
    }

    public function coments()
    {
        return $this->hasMany('App\Commentaire', 'sprint_id');
    }

    public function actif()
    {
        $sprints = Sprint::all()->where('phase',"actif")->first();

        if($sprints === null)
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    public function phase()
    {
        if($this->phase ==="undone")
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function fichiers()
    {
        return $this->hasMany('App\Fichier', 'sprint_id');
    }

    public function developers()
    {
        $developers = array();

        foreach($this->userStories as $userStory)
        { 
            array_push($developers,$userStory->developer);   
        }
        return $developers;
    }
}
