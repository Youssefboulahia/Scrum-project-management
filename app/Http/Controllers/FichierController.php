<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sprint;
use App\Fichier;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use View;
use App\Project;

class FichierController extends Controller
{
    public function fichierEnvoyer(Request $request, $id)
    {
    
        $sprint = Sprint::where('name',$request->input('sprint'))->first();

        $fichier = new Fichier;
        $fichier->message = $request->input('message');
        $fichier->sprint_id = $sprint->id;
        $fichier->importeur_id = auth()->user()->id;

        if($request->hasFile('fichier'))
        {
            $fichier->fichier = $request->fichier->store('fichier','public');
        }
        $format = \File::extension($fichier->fichier);
        $fichier->format = $format;
        $fichier->save();


        return redirect()->to('dashboard/fichier/'.$id);
    }

    public function fichierDownload($id)
    {

        $fichier= Fichier::find($id)->fichier;

        $file_path =storage_path('app/public/' . $fichier);

        $headers = array(
            'Content-Type: application/vnd.ms-word application/pdf ;image/png ;application/msword;'
          );

        $response = Response::download($file_path);
        return $response;

    }

    public function fichierVoir($id)
    {

        $fichier= Fichier::find($id)->fichier;

        $file_path =Storage::get('public/'.$fichier);
    
        $headers = array(
            'Content-Type: application/vnd.ms-word application/pdf ;image/png ;application/msword;'
          );
          $response = Response::make($file_path,200);
          $response->header('Content-Type', $headers);
          return $response;

    }


    public function fichierFiltrer(Request $request,$id)
    {

        $view = View::make('dashboard.fichier');
        $view->project = Project::find($id);
        $view->sprints = Sprint::all();
        $view->filterSprint ="notnull";
        $filter = Sprint::where('name',$request->input('filterSprint'))->first();

        $view->filterSprints = $filter->fichiers;

        return $view;
    }
    
    public function fichierSupprimer(Request $request, $id)
    {

        $fichier = Fichier::find($request->input('fichier'));
        $fichier->delete();
        return redirect()->to('dashboard/fichier/'.$id);
    }





}
