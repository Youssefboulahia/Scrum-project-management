<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Sprint;
use App\fichier;
use App\GroupeDiscussion;

class AgendaController extends Controller
{
    public function getData()
    {
        $date_now = Carbon::now()->format('yy-m-d');

        $arr = array(
            "data"=>[],
            "date"=> $date_now,
        );

        $sprints = Sprint::all();

        foreach($sprints as $sprint)
        {
            if($sprint->phase === 'undone')
            {
                array_push($arr['data'],array(
                    "title" => "Sprint: ".$sprint->name,
                    "start" => Carbon::parse($sprint->created_at)->format('yy-m-d'),
                    "color" =>'#275BFF',
                    "textColor" => '#fff'
                ));
            }
            elseif($sprint->phase === 'actif')
            {
                array_push($arr['data'],array(
                    "title" => "Sprint: ".$sprint->name,
                    "start" => Carbon::parse($sprint->startDate)->format('yy-m-d'),
                    "end" => Carbon::parse($sprint->endDate)->format('yy-m-d'),
                    "color" =>'#EAB70E',
                    "textColor" => '#fff'
                ));
            }
            elseif($sprint->phase === 'done')
            {
                array_push($arr['data'],array(
                    "title" => "Sprint: ".$sprint->name,
                    "start" => Carbon::parse($sprint->endDate)->format('yy-m-d'),
                    "color" =>'#4BB543',
                    "textColor" => '#fff'
                ));
            }
        }

        $fichiers = Fichier::all();

        foreach($fichiers as $fichier)
        {
            array_push($arr['data'],array(
                "title" => "Fichier: ".$fichier->format,
                "start" => Carbon::parse($fichier->crated_at)->format('yy-m-d'),
                "color" =>'#8B00F8',
                "textColor" => '#fff'
            ));
        }

        $groupes = GroupeDiscussion::all();

        foreach($groupes as $groupe)
        {
            array_push($arr['data'],array(
                "title" => "Groupe: ".$groupe->title,
                "start" => Carbon::parse($groupe->crated_at)->format('yy-m-d'),
                "color" =>'#F83A3A',
                "textColor" => '#fff'
            ));
        }

        foreach($sprints as $sprint)
        {
            if($sprint->phase ==='actif')
            {
                foreach($sprint->userStories as $us)
                {
                    if($us->phase ==='done')
                    {
                        array_push($arr['data'],array(
                            "title" =>$us->developer->name." a avancé",
                            "start" => Carbon::parse($us->updated_at)->format('yy-m-d'),
                            "color" =>'#00B626',
                            "textColor" => '#fff'
                        ));
                    }
                }
            }
        }

       

        
        
      
        return $arr;
    }
}
