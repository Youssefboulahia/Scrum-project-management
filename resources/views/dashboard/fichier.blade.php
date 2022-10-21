@extends('layouts.admin',['projectId'=>$project->id])

@section('projectName')
    {{$project->name}}
@endsection


    
@section('content')


  @if($filterSprint==="null" && $fichiers->count()===0 )
    <div class="container">
        <div class="centered text-center">
            <img src="{{ asset('assets/fichier.png') }}" alt="aucun fichier" style="width:21%" class="mb-2">
            <h3 class="text-muted">Il y a aucun fichier pour l'instant</h3>
            @if((Auth()->user()->isProductOwner($project->id)))
                <div class="mt-3 bg-white" style="display:inline-block">
                    <button type="button" class="btn btn-outline-dark pull-right "data-toggle="modal" data-target="#exampleModal" style="font-size:14.5px"><i class="fa fa-upload"></i> Importer fichier</button>
                </div>
            @endif

            @if(!(Auth()->user()->isProductOwner($project->id))  &&   count(Auth()->user()->sprints()) >0   )
                <div class="mt-3 bg-white" style="display:inline-block">
                    <button type="button" class="btn btn-outline-dark pull-right "data-toggle="modal" data-target="#exampleModal" style="font-size:14.5px"><i class="fa fa-upload"></i> Importer fichier</button>
                </div>
            @endif
        </div>
    </div>


    @else

    <div class="container">
        
            @if((Auth()->user()->isProductOwner($project->id)))
                <div class="bg-white d-inline-block" >
                    <button type="button" class="btn btn-outline-dark pull-right "data-toggle="modal" data-target="#exampleModal" style="font-size:14.5px"><i class="fa fa-upload"></i> Importer fichier</button>
                </div>
            @endif

            @if(!(Auth()->user()->isProductOwner($project->id))  &&   count(Auth()->user()->sprints()) >0   )
                <div class="bg-white d-inline-block" >
                    <button type="button" class="btn btn-outline-dark pull-right "data-toggle="modal" data-target="#exampleModal" style="font-size:14.5px"><i class="fa fa-upload"></i> Importer fichier</button>
                </div>
            @endif


    <form action="{{ route('fichier.filtrer',$project->id) }}" method="GET">
        <div class="row justify-content-end mb-2" style="position:relative;top:6px">
                <div class="col-auto">
                        <div class="form-group d-inline-block border-zero">
                                <select name="filterSprint" class="form-control border-zero" id="exampleFormControlSelect1" style="height:30px; min-width:200px ">
                                  <option value="" disabled selected hidden>Choisissez Sprint</option>
                                  @foreach ($sprints as $sprint )
                                      <option>{{ $sprint->name }}</option>
                                  @endforeach
                                </select>
                              </div>               
                </div>
                <div class="col-auto" style="margin-left:-30px">
                        <button type="submit" class="btn btn-labeled btn-primary" style=" height:30px;border-top-left-radius: 0px;border-bottom-left-radius: 0px;">
                                <i class="fa fa-filter btn-label" aria-hidden="true"></i>
                            <span class="ml-n2">Filtrer</span>
                        </button>
                </div>
        
        
            </div>
        </form>


        <div class="bg-whi0te">
                <table class="table table-hover">
                        <thead class="thead-light">
                          <tr>
                            <th scope="col" style="width:4%">#</th>
                            <th scope="col" style="width:14%">Utilisateur</th>
                            <th scope="col" style="width:20%">Sprint</th>
                            <th scope="col" style="width:32%">Message</th>
                            <th scope="col" style="width:7%">Format</th>
                            <th scope="col" style="width:23%">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          @if ($filterSprint==="null")
                                @foreach ($fichiers as $fichier)
                                <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $fichier->importeur->name }}</td>
                                        <td>{{ $fichier->sprint->name }}</td>
                                        <td>{{ $fichier->message }}</td>
                                        <td>.{{ $fichier->format }}</td>
                                        <td>
                                         
                                              <a href="{{ route('fichier.download',$fichier->id) }}" class="btn btn-primary btn-sm text-white"><i class="fa fa-download" aria-hidden="true"></i><span class="ml-1">Télécharger</span></a>    
                                              @if ($fichier->format==='pdf'||$fichier->format==='txt'||$fichier->format==='jpeg'||$fichier->format==='png'||$fichier->format==='html')
                                                 <a href="{{ route('fichier.voir',$fichier->id) }}" class="btn btn-outline-primary btn-sm text-primary"><i class="fa fa-eye" aria-hidden="true"><span class="ml-1">Ouvrir</span></i></a>    
                                              @else
                                                 <a  class="btn btn-outline-dark btn-sm text-muted" style="pointer-events: none;"><i class="fa fa-eye" aria-hidden="true"><span class="ml-1">Ouvrir</span></i></a>     
                                              @endif                
                                              
                                              <input type="text" hidden value="{{ $fichier->id }}" name="fichier">
                                              @if((Auth()->user()->isProductOwner($project->id)))
                                              <button type="submit" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#delete" data-id="{{ $fichier->id }}"><i class="fas fa-trash-alt"></i></button>  
                                              @elseif( !(Auth()->user()->isProductOwner($project->id)) )
                                                 @foreach (Auth()->user()->fichiers as $fch )
                                                     @if ($fichier->id === $fch->id)
                                                         <button type="submit" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#delete" data-id="{{ $fichier->id }}"><i class="fas fa-trash-alt"></i></button>  
                                                     @endif
                                                 @endforeach
                                              @endif
                                             
                                        </td>
                                    </tr>
                                @endforeach
                          @else
                            @foreach ($filterSprints as $fichier)
                                    <tr>
                                            <th scope="row">{{ $loop->iteration }}</th>
                                            <td>{{ $fichier->importeur->name }}</td>
                                            <td>{{ $fichier->sprint->name }}</td>
                                            <td>{{ $fichier->message }}</td>
                                            <td>.{{ $fichier->format }}</td>
                                            <td>
                                                <a href="{{ route('fichier.download',$fichier->id) }}" class="btn btn-primary btn-sm text-white"><i class="fa fa-download" aria-hidden="true"></i><span class="ml-1">Télécharger</span></a>                    
                                                <a href="{{ route('fichier.voir',$fichier->id) }}" class="btn btn-outline-primary btn-sm text-primary"><i class="fa fa-eye" aria-hidden="true"><span class="ml-1">Ouvrir</span></i></a>      
                                                <input type="text" hidden value="{{ $fichier->id }}" name="fichier">
                                                @if((Auth()->user()->isProductOwner($project->id)))
                                                <button type="submit" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#delete" data-id="{{ $fichier->id }}"><i class="fas fa-trash-alt"></i></button>  
                                                @else

                                                @endif
                                            </td>
                                    </tr>
                            @endforeach
                
                          @endif
                        </tbody>
                      </table>
                      @if ($filterSprint==="null")
                      {{ $fichiers->links() }}
                      @endif
        </div>
    
</div>

@endif


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header" style="height:55px">
              <h5 class="modal-title" id="exampleModalLabel">Importer fichier</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body pt-0">
                   <div class="pt-3">
                        <form action="{{ route('fichier.envoyer',$project->id) }}" enctype="multipart/form-data" method="POST">
                            @csrf
                    
                            
                            <div class="form-group">
                                    <input type="text" style="height:60px" class="form-control" id="exampleFormControlInput1" placeholder=" Votre message ..." required name="message">
                            </div>


                            @if(!(Auth()->user()->isProductOwner($project->id))  &&   count(Auth()->user()->sprints()) >0   )
                                <div class="form-group">
                                    <select id="inputState" class="form-control" required name="sprint">
                                      <option value="" disabled selected hidden>Choisissez Sprint</option>
                                      @foreach (Auth()->user()->sprints() as $sprint )
                                          <option>{{ $sprint }}</option>
                                      @endforeach
                                    </select>
                                </div>
                            @endif

                            @if((Auth()->user()->isProductOwner($project->id)))
                                  <div class="form-group">
                                      <select id="inputState" class="form-control" required name="sprint">
                                        <option value="" disabled selected hidden>Choisissez Sprint</option>
                                        @foreach ($sprints as $sprint )
                                            <option>{{ $sprint->name }}</option>
                                        @endforeach
                                      </select>
                                  </div>
                            @endif
                            
                            
                            <button class="btn btn-primary mb-2 mt-3"  type="submit">Envoyer</button>  
                            <label for="file-upload" class="custom-file-upload" style="cursor:pointer">
                                    <i class="fa fa-paperclip ml-2 text-muted" aria-hidden="true"></i>
                                    <span style="font-size:14px" class="text-muted">Importer un fichier</span> 
                            </label>
                            <input id="file-upload" type="file" hidden name="fichier" required/>   
                            </div>
                    
                     </form>
                   </div>
            </div>
          </div>
        </div>
      </div>






       <!-- Modal -->
       <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Effacer fichier</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">      
                  Êtes-vous sur?
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Non</button>
                <form action="{{ route('fichier.supprimer',$project->id) }}" method="POST">
                    @csrf
                    <button class="btn btn-primary" >Oui</button>
                    <input type="text" name="fichier" id="fichier" hidden>
                    </form>
              </div>
            </div>
          </div>
        </div>



@endsection
















@section('js')
    
      <script>
      $('#delete').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var id = button.data('id') // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    $("#fichier").val(id);
  })
        
      </script>
      
@endsection