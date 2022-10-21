<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use View;
use App\Project;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $projects = Auth()->user()->projects;
        $developerProjects = Auth()->user()->developerProjects;
        $view = View::make('home');
        $view->projects = $projects;
        $view->developerProjects = $developerProjects;
        return $view ;
    }
}
