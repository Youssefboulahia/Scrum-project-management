<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserStory;
use App\Notification;
use App\Project;
use Carbon\Carbon;

class UserStoryController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$id)
    {
        $userStory = new UserStory;
       
        $userStory->description = $request->input('description');
        $userStory->priority = $request->input('priorité');
        $userStory->estimation = $request->input('éstimation');
        $userStory->phase = "undone";
        $userStory->project_id = $id;

        $userStory->save();
       
        return redirect()->to('dashboard/userStory/'.$id);
    }

    public function delete(Request $request,$id)
    {
        $userStory = UserStory::find($request->input('userStoryId'));
        $userStory->delete();
        return redirect()->to('dashboard/userStory/'.$id);
    }
    public function done(Request $request,$id)
    {
        $userStory = UserStory::find($request->input('userStoryId'));
        $userStory->phase="done";
        $userStory->update();

        return redirect()->to('dashboard/userStory/'.$id);
    }
    public function undone(Request $request,$id)
    {
        $userStory = UserStory::find($request->input('userStoryId'));
        $userStory->phase="undone";
        $userStory->update();

        return redirect()->to('dashboard/userStory/'.$id);
    }
    public function update(Request $request, $id)
    {
        $userStory = UserStory::find($request->input('userStoryId'));
        $userStory->description = $request->input('description');
        $userStory->priority = $request->input('priorité');
        $userStory->estimation = $request->input('éstimation');
        $userStory->update();

        return redirect()->to('dashboard/userStory/'.$id);

    }

    public function undoneSprint(Request $request,$id)
    {
        $userStory = UserStory::find($request->input('userStoryId'));
        $userStory->phase="between";
        $userStory->update();
        $project = Project::find($id);

        $notification = new Notification;
        $notification->notified_id = $project->productOwner->id;
        $notification->sprint_id = $userStory->sprint->id;
        $notification->seen = "no";
        $notification->description = "sprintUndone";
        $notification->name = $userStory->developer->name;
        $notification->save();


        return redirect()->to('dashboard/sprint/'.$id);
    }

    public function doneSprint(Request $request,$id)
    {
        $userStory = UserStory::find($request->input('userStoryId'));
        $userStory->phase="done";
        $userStory->updated_at=Carbon::now();
        $userStory->update();
        $project = Project::find($id);

        $notification = new Notification;
        $notification->notified_id = $project->productOwner->id;
        $notification->sprint_id = $userStory->sprint->id;
        $notification->seen = "no";
        $notification->description = "sprintDone";
        $notification->name = $userStory->developer->name;
        $notification->save();


        return redirect()->to('dashboard/sprint/'.$id);
    }
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
