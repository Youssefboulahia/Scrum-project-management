<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use View;
use App\Project;
use App\UserStory;
use App\Sprint;
use Carbon\Carbon;
use App\Fichier;
use App\GroupeDiscussion;
use App\Notification;
use App\Chart;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    public function start($id)
    {
        $view = View::make('dashboard.index');
        $view->project = Project::find($id);
        $view->userStories = UserStory::all()->where('project_id',$id);

        return $view;
    }

    public function sprint($id)
    {
        $view = View::make('dashboard.sprint');
        $view->project = Project::find($id);
        $view->userStories = UserStory::all()->where('project_id',$id);
        $view->sprint = Sprint::where('project_id',$id)->get();

        $sprint = Sprint::all()->where('phase','actif')->first();
        if($sprint!== null)
        {
            if(!Carbon::parse($sprint->endDate)->isPast())
            {
                $date_now = Carbon::now();
                $date_end = Carbon::parse($sprint->endDate);
                $day_diff = $date_now->diffInDays($date_end);
                $sprint->dayDiff = $day_diff;
            
                $new_with_day = Carbon::now()->addDays($day_diff);
                
                $sprint->hourDiff = $new_with_day->diffInHours($date_end);
        
                $new_with_hours = $new_with_day->addHours($new_with_day->diffInHours($date_end));
        
                $sprint->minuteDiff = $new_with_hours->diffInMinutes($date_end);
        
                $sprint->update();
            }
            else
            {
                $sprint->dayDiff = 0;
                $sprint->hourDiff = 0;
                $sprint->minuteDiff = 0;

                $sprint->phase = "done";

                $project = Project::find($id);

                $notification = new Notification;
                $notification->notified_id = $project->productOwner->id;
                $notification->sprint_id = $sprint->id;
                $notification->seen = "no";
                $notification->description = "sprintEnd";
                $notification->save();

                $sprint->update();
            }

        
        }
        

        return $view;
    }



    public function fichier($id)
    {
        $view = View::make('dashboard.fichier');
        $view->project = Project::find($id);
        $view->fichiers = Fichier::paginate(6);
        $view->sprints = Sprint::all();
        $view->filterSprint ="null";

       
        return $view;
    }

    public function groupeDiscussion($id)
    {
        $view = View::make('dashboard.groupeDiscussion');
        $view->project = Project::find($id);
        $view->groupes = GroupeDiscussion::paginate(4);
        return $view;
    }

    public function burndownChart($id)
    {
        $view = View::make('dashboard.burndownChart');
        $view->project = Project::find($id);

        $chart = Chart::all()->first();
        if($chart !== null)
        {
            $sprint = Sprint::find($chart->sprint_id);


            if(3<1);
        {
            $total = 0;
            foreach($sprint->userStories as $us)
            {
                if($us->phase !== "done")
                {
                    $total = $total + $us->estimation;
                }
               
            }

            $chart->data = $chart->data.",'$total'";
            $chart->dayCheck = Carbon::now();

            $chart->save();
        }
        }

        


        $view->chart = $chart;

        return $view;
    }


    public function calendrier($id)
    {
        $view = View::make('dashboard.calendrier');
        $view->project = Project::find($id);
        return $view;
    }

    public function test()
    {
        return Project::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
