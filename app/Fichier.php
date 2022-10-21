<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Sprint;

class Fichier extends Model
{
    protected $table = 'fichier';

    public function sprint()
    {
        return $this->belongsTo('App\Sprint','sprint_id');
    }

    public function importeur()
    {
        return $this->belongsTo('App\User','importeur_id');
    }

    public static function sprints()
    {
        $fichiers = Fichier::all();
        $sprints = array();

        foreach($fichiers as $fichier)
        {
            if(!in_array($fichier->name,$sprints))
                {
                    array_push($sprints,$fichier->name);
                }
        }

        return $sprints;
    }
}
