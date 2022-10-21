<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\Invitation;
use App\Project;

class InvitationController extends Controller
{


    
    public function inviter(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string', 'email', 'max:255', 'exists:users'],
        ]);

        $id = $request->input('projectId');

        $developer = User::where('email', $request->input('email')) -> first();

        $invitation = Invitation::where('productOwner_id',Auth()->user()->id)->where('developer_id',$developer->id)->first();

        $developerExist = Project::find($id)->projectDevelopers()->where('users.id',$developer->id)->get();

        if(empty($invitation))
        {
            if(count($developerExist)>0)
            {
                session()->flash('exist','Le développeur est deja dans le projet');
                return redirect('home');
            }
            else{

                $invitation_perso = new invitation;
                $invitation_perso->productOwner_id = Auth()->user()->id;
                $invitation_perso->developer_id = $developer->id;
                $invitation_perso->project_id = $id;
                $invitation_perso->save();
                $developer->save();
                return redirect('home');

            }
            
        }
        else
        {
            $invitation_proj = Invitation::where('productOwner_id',Auth()->user()->id)->where('developer_id',$developer->id)->where('project_id',$id)->first();

            if(!empty($invitation_proj))
            {
                session()->flash('error', 'Le développeur est deja invité à ce projet');
                return redirect('home');
            }
            elseif(count($developerExist)>0)
            {
                session()->flash('exist','Le développeur est deja dans le projet');
                return redirect('home');
            }
            else
            {
                $invitation_perso = new invitation;
                $invitation_perso->productOwner_id = Auth()->user()->id;
                $invitation_perso->developer_id = $developer->id;
                $invitation_perso->project_id = $id;
                $invitation_perso->save();
                $developer->save(); 
                return redirect('home');
            }
        }
        
    }


    public function annuler(Request $request)
    {
        $id = $request->input('invitationId');

        $invitation = Invitation::find($id);
        $invitation->delete();
        session()->flash('invitationAnnuler','Invitation a été annulé');
        return redirect('home');
    }


    public function accepter(Request $request)
    {
        $id = $request->input('invitationIdd');
        $invitation = Invitation::find($id);

        Auth()->user()->developerProjects()->attach($invitation->project_id);

        $invitation->delete();

        session()->flash('invitationAccepter','Invitation a été accepté');
        return redirect('home');
    }
}
