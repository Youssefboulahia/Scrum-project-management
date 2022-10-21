<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\SocialAccount;
use App\Invitation;
use App\Project;
use App\Sprint;
use App\UserStory;
use App\DiscussionDeveloper;
use App\Notification;

class User extends Authenticatable 
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function projects(){
        return $this ->hasMany('App\Project', 'id_productOwner');
    }

    public function profile()
    {
        return $this->hasOne('App\Profile');
    }
    public function getCheckedGravatar()
    {
       
        if(preg_match('/gravatar/',$this->profile->picture,$match))
        {
             return $this->getGravatar();
        }
        else{
            return $this->profile->picture;
        }
        
    }

    public function getGravatar()
    {
        $hash = md5(strtolower(trim($this->attributes['email'])));
        return "http://gravatar.com/avatar/$hash";
    }
    public function getPicture()
    {
        return $this->profile->picture;
    }
    public function hasPicture()
    {
        if(preg_match('/profilesPicture/',$this->profile->picture,$match))
        {
            return true;
        }
        else{
            return false;
        }
    }

    public function accounts()
    {
        return $this->hasMany(SocialAccount::class);
    }




    public function developersInvite() {
        return $this->belongsToMany('App\User', 'invitations', 'productOwner_id', 'developer_id');
      }
    
      public function productOwnerInvite() {
        return $this->belongsToMany('App\User', 'invitations', 'developer_id', 'productOwner_id');
      }

      public function getSendedInvitations()
      {
        $invitations = Invitation::all()->where('productOwner_id',$this->id);
        return $invitations;
      }
      public function getRecievedInvitations()
      {
        $invitations = Invitation::all()->where('developer_id',$this->id);
        return $invitations;
      }



      public function developerProjects() {
        return $this->belongsToMany('App\Project', 'project_developer', 'developer_id', 'project_id');
      }


      public function isProductOwner($id)
      {
          $project = Project::find($id);
          if($this->id == $project->id_productOwner)
          {
              return true;
          }
          else
          {
              return false;
          }
      }

      public function verifyDeveloper($id)
      {
          $sprint = Sprint::find($id);
          $userStories = $sprint->userStories;
          foreach($userStories as $us)
          {
              if ($this->id === $us->developer->id)
              {
                  return true;
              }
          }
          return false;
      }

      public function userStories()
    {
        return $this->hasMany('App\UserStory', 'developer_id');
    }

    public function sprints()
    {
        $userStories = $this->userStories()->get();
        $sprints = array();

        foreach($userStories as $userStory)
        {
            if($userStory->sprint() !== null)
            {
                if(!in_array($userStory->sprint->name,$sprints))
                {
                    array_push($sprints,$userStory->sprint->name);
                }
            }
        }
        return $sprints;
    }

    public function fichiers()
    {
        return $this->hasMany('App\Fichier', 'importeur_id');
    }

    public function fichier_name()
    {
        $fichiers = $this->fichiers();
        $fichierName = array();
        foreach($fichiers as $fichier)
        {
            push_array($fichierName,$fichier->id);
        }
        return $fichierName;
    }
    
    public function groupedeveloper()
    {
        return DiscussionDeveloper::where('developer_id',$this->id)->get();
    }
     
    public function notifications()
    {
        return Notification::where('notified_id',$this->id)->orderBy('created_at', 'desc')->take(4)->get();
    }

    public function notificationsChecked()
    {
        return Notification::where('notified_id',$this->id)->where('seen','no')->orderBy('created_at', 'desc')->take(4)->get();
    }
}
