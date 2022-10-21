<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Project;

class Invitation extends Model
{
    protected $table = 'invitations';

    public function getDeveloper($id)
    {
        $developer = User::find($id);
        return $developer;
    }
    public function getProject($id)
    {
        $project = Project::find($id);
        return $project;
    }
    public function getProductOwner($id)
    {
        $productOwner = User::find($id);
        return $productOwner;
    }

    
}
