<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use View;
use App\Project;
use App\UserStory;
use App\Sprint;
use App\User;
use App\Commentaire;
use Carbon\Carbon;
use App\Notification;
use App\Chart;

class SprintController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }


    public function open($id)
    {
        $view = View::make('sprint.index');
        $project = Project::find($id);
        $userStory = UserStory::where('project_id',$id)->get();
        $developers = $project->projectDevelopers;
        $view->project =$project;
        $view->userStory=$userStory;
        $view->developers=$developers;
        return $view;
    }

    public function store(Request $request,$id)
    {
        $keydev=-1;
        $request->validate([
            'nom' => 'required',
            'délai' => 'required',
        ]);


        $sprint = new Sprint;
            $sprint->name = $request->input('nom');
            $sprint->time = $request->input('délai');
            $sprint->phase = "undone";
            $sprint->project_id = $id;
            $sprint->save();

        foreach($request->input('select') as $key => $value) {
            $keydev=$key;
            $userStory = UserStory::where('description',$value)->first();
            $userStory->phase = "between";
            $userStory->sprint_id = $sprint->id;
            $userStory->update();
            foreach($request->input('dev') as $key => $value) {
                if($key===$keydev)
                {
                   $user = User::where('name',$value)->first();
                   $userStory->developer_id = $user->id;
                   $userStory->update();

                   $notification = new Notification;
                   $notification->notified_id = $user->id;
                   $notification->sprint_id = $sprint->id;
                   $notification->seen = "no";
                   $notification->description = "sprintAffecter";
                   $notification->save();
                }
            }

        }
        
        return redirect()->to('dashboard/sprint/'.$id);
    }

    public function comment(Request $request,$project_id,$sprint_id)
    {
        $comment = new Commentaire;
        $comment->text = $request->input('comment');
        $comment->sprint_id = $sprint_id;
        $comment->writer_id = Auth()->user()->id;

        $comment->save();

        return redirect()->to('dashboard/sprint/'.$project_id);
    }

    public function delete(Request $request,$id)
    {
        $comment = Commentaire::find($request->input('commentId'));
        $comment->delete();
        return redirect()->to('dashboard/sprint/'.$id);
    }

    public function sprintDelete(Request $request,$id)
    {
        $sprint = Sprint::find($request->input('sprId'));

        $notifications = Notification::where('sprint_id',$sprint->id)->get();

        foreach($notifications as $notification)
        {
            $notification->delete();
        }

        $developers = $sprint->developers();

        $project = Project::find($id);

        foreach($developers as $dev)
        {
            
            $notification = new Notification;
            $notification->notified_id = $dev->id;
            $notification->sprint_id = $sprint->id;
            $notification->seen = "no";
            $notification->description = "sprintEffacer";
            $notification->name = $sprint->name;
            $notification->save();
        }

        $userStories = $sprint->userStories;
        foreach($userStories as $us)
        {
            $us->phase = "undone";
            $us->developer_id = null;
            $us->sprint_id = null;
            $us->update();
        }

        $comments = $sprint->coments;
        foreach($comments as $comment)
        {
            $comment->delete();
        }


        $sprint->delete();
        return redirect()->to('dashboard/sprint/'.$id);
    }

    public function start(Request $request,$id)
    {
        $sprint_id = $request->input('id');
        $sprint = Sprint::find($sprint_id);
        $sprint->phase = "actif";
        $sprint->startDate = Carbon::now()->format('Y-m-d H:i:s');
        if($sprint->time ==="2 semaines")
        {
            $sprint->endDate = Carbon::now()->addDays(14)->format('Y-m-d H:i:s');
        }
        elseif($sprint->time ==="3 semaines")
        {
            $sprint->endDate = Carbon::now()->addDays(21)->format('Y-m-d H:i:s');
        }
        elseif($sprint->time ==="4 semaines")
        {
            $sprint->endDate = Carbon::now()->addDays(28)->format('Y-m-d H:i:s');
        }
        $date_start = Carbon::parse($sprint->startDate);
        $date_end = Carbon::parse($sprint->endDate);
        $sprint->dayDiff = $date_start->diffInDays($date_end)-1;
        $sprint->hourDiff = 23;
        $sprint->minuteDiff = 59;

        $sprint->update();

        foreach($sprint->developers() as $developer)
        {
                   $notification = new Notification;
                   $notification->notified_id = $developer->id;
                   $notification->sprint_id = $sprint->id;
                   $notification->seen = "no";
                   $notification->description = "sprintLancer";
                   $notification->save();
        }

        $oldChart = Chart::all();
        foreach($oldChart as $chart)
        {
            $chart->delete();
        }

        $chart = new Chart;
        $chart->sprint_id = $sprint_id;
        if($sprint->time === '2 semaines')
        {
            $chart->sommeDays = 14;
        }
        elseif($sprint->time === '3 semaines')
        {
            $chart->sommeDays = 21;
        }
        elseif($sprint->time === '4 semaines')
        {
            $chart->sommeDays = 28;
        }

        $total = 0;
        foreach($sprint->userStories as $us)
        {
            $total = $total + $us->estimation;
        }

        $chart->sommePoints = $total;

        $chart->dayCheck = Carbon::now();

        $chart->data = "'$total'";

        $chart->save();
        

        return redirect()->to('dashboard/sprint/'.$id);
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
  

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
