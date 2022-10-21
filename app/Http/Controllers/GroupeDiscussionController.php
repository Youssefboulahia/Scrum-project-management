<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use View;
use App\Project;
use App\GroupeDiscussion;
use App\DiscussionDeveloper;
use App\User;
use App\Message;
use App\Notification;

class GroupeDiscussionController extends Controller
{
    public function chat($projecy_id,$groupe_id)
    {
        $view = View::make('groupeDiscussion.chat');
        $view->project = Project::find($projecy_id);
        $view->groupe = GroupeDiscussion::find($groupe_id);
        $view->messages = Message::all()->where('groupeDiscussion_id',$groupe_id)->all();
        return $view;
    }


    public function create(Request $request, $id)
    {
        $groupe = new GroupeDiscussion;
            

        $groupe->title = $request->input('titre');
        $groupe->description = $request->input('description');
        $groupe->project_id = $id;
        $groupe->productOwner_id = Project::find($id)->productOwner->id;

        $groupe->save();

    
        foreach($request->input('select') as $key => $value) {
            
            $groupeDeve = new DiscussionDeveloper;
            $groupeDeve->groupeDiscussion_id = $groupe->id;
            $groupeDeve->developer_id = User::where('name',$value)->first()->id;
            $groupeDeve->save();

            $notification = new Notification;
            $notification->notified_id = User::where('name',$value)->first()->id;
            $notification->groupe_id = $groupe->id;
            $notification->seen = "no";
            $notification->description = "groupeAffecter";
            $notification->save();
        }

        return redirect()->to('dashboard/groupeDiscussion/'.$id);

    }

    public function message(Request $request, $id)
    {

        $groupeId = $request->input('groupe');

        $message = new Message;
        $message->message = $request->input('message');
        $message->groupeDiscussion_id = $groupeId;
        $message->writer_id = Auth()->user()->id;

        $message->save();


        return redirect()->to('chat/room/'.$id.'/'.$groupeId);
    }

    public function groupeDelete(Request $request,$id)
    {
        

        $groupe = GroupeDiscussion::find($request->input('groupeId'));

        $notifications = Notification::where('groupe_id',$groupe->id)->get();

        foreach($notifications as $notification)
        {
            $notification->delete();
        }

        $developers = $groupe->groupeDevelopers();

        $project = Project::find($id);

        foreach($developers as $dev)
        {
            $notification = new Notification;
            $notification->notified_id = $dev->developer_id;
            $notification->groupe_id = $groupe->id;
            $notification->seen = "no";
            $notification->description = "groupeEffacer";
            $notification->name = $groupe->title;
            $notification->save();

            $dev->delete();
        }

        $messages = $groupe->messages();

        foreach($messages as $msg)
        {
            $msg->delete();
        }

        

        $groupe->delete();

        return redirect()->to('dashboard/groupeDiscussion/'.$id);
    }
}
