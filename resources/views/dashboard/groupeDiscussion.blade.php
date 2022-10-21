@extends('layouts.admin',['projectId'=>$project->id])

@section('projectName')
    {{$project->name}}
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/discu.css') }}">
@endsection

    
@section('content')




@if((Auth()->user()->isProductOwner($project->id))  &&  $groupes->count()===0)
  <div class="container">
      <div class="centered text-center">
          <img src="{{ asset('assets/chat.png') }}" alt="aucun sprint" style="width:30%" class="mt-n4" >
          <h3 class="text-muted">Il y a aucun groupe de discussion pour l'instant</h3> 
            <div class="mt-3 bg-white" style="display:inline-block">
              <a data-toggle="modal" data-target="#createChat" class="btn btn-outline-dark pull-right" style="font-size:14.5px"><i class="fa fa-plus"></i> Créer groupe de discussion</a>
            </div>
      </div>
  </div>


@elseif( !(Auth()->user()->isProductOwner($project->id))   &&   (Auth()->user()->groupedeveloper()->count()===0   ))
               
<div class="container">
        <div class="centered text-center">
            <img src="{{ asset('assets/chat.png') }}" alt="aucun sprint" style="width:30%" class="mt-n4" >
            <h3 class="text-muted">Vous n'etes pas affecté à aucun groupe de discussion</h3> 
        </div>
    </div>

@else

@if((Auth()->user()->isProductOwner($project->id)))
<div class="bg-white d-inline-block mb-n2">
        <button type="button" class="btn btn-outline-dark pull-right" style="font-size:15px" data-toggle="modal" data-target="#createChat" style="font-size:13.5px"><i class="fa fa-plus"></i> Créer groupe de discussion</button>
</div>
@endif


<div class="row">

       
        @if((Auth()->user()->isProductOwner($project->id)))
        @foreach ($groupes as $groupe )
        <div class="col-sm-6 mt-4">
                <div class="card border-left-primary shadow h-100 pt-2 border-right-primary border-top-primary">
                  <div class="card-body">
                        <div style="position:absolute; left :495px; top:0.1mm">
                                <div>
                                        <i class="fa fa-times text-danger" style="cursor:pointer" aria-hidden="true" data-id="{{ $groupe->id }}" data-toggle="modal" data-target="#deleteGroupe"></i>
                               </div>
                            </div>
                    <div class="row no-gutters align-items-center">
                      <div class="col mr-2" style="z-index:10">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                <div class="row  justify-content-around"style="position:relative;top:-7px;">
                                        <div class="col text-center" style="font-size:14.5px">
                                                <div style="position:relative; bottom:4px">
                                                        <span class=" mr-1" style="font-size:18px;color:#4E73DF">Titre:</span> <span style="color:#7a7374;font-size:18px">{{ $groupe->title }}</span>
                                                </div>
                                        </div>
                                        <div class="col text-right" style=" color:#4E73DF;position:absolute; right:9px ;bottom:26px;font-size:14.5px; font-family: 'Lato', sans-serif;font-weight:500">
                                                <span>{{ $groupe->created_at->format('d M') }}</span>
                                        </div>
                                </div>
                        </div>

                        <div class="text-xs font-weight-bold text-info mb-1 mt-n3 mb-2">
                            <span style="font-size:18px">Description</span>
                        </div>
                       <div class="mt-n1 text-muted" style="font-size:14.5px">
                            {{ $groupe->description }}
                       </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"></div>
                      </div>
                      <div class="col-auto" style="position:absolute;left:77%;top:24%">
                        <i class="fas fa-comments " style="font-size:90px; color:rgba(221, 223, 235, 0.5)"></i>
                      </div>
                    </div>
                  </div>

                  <a href="{{ route('chat.index',['project_id'=>$project->id, 'groupe_id'=>$groupe->id]) }}">
                        <div class="card-footer text-center" style="cursor:pointer;  border-bottom-left-radius: 0px; background-color:#4E73DF">
                              <div class="h5 mb-0 text-white" style="font-size:18px">
                                
                                  <i class="fa fa-arrow-right mr-1 text-white" style="font-size:16.5px"></i>
                                  Entrer
                                        
                              </div>
                          </div>
                      </a> 
                    
                </div>
              </div>
              @endforeach

              @elseif(Auth()->user()->groupedeveloper() !== null)
                @foreach (Auth()->user()->groupedeveloper() as $d )
                    @foreach ($d->groupesDiscussion() as $groupe )
                
                    <div class="col-sm-6 mt-4">
                                <div class="card border-left-primary shadow h-100 pt-2 border-right-primary border-top-primary">
                                  <div class="card-body">
                                       
                                    <div class="row no-gutters align-items-center">
                                      <div class="col mr-2" style="z-index:10">
                                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                <div class="row  justify-content-around"style="position:relative;top:-7px;">
                                                        <div class="col text-center" style="font-size:14.5px">
                                                                <div style="position:relative; bottom:4px">
                                                                        <span class=" mr-1" style="font-size:18px;color:#4E73DF">Titre:</span> <span style="color:#7a7374;font-size:18px">{{ $groupe->title }}</span>
                                                                </div>
                                                        </div>
                                                        <div class="col text-right" style=" color:#4E73DF;position:absolute;left:10px ;bottom:26px;font-size:14.5px; font-family: 'Lato', sans-serif;font-weight:500">
                                                                <span>{{ $groupe->created_at->format('d M') }}</span>
                                                        </div>
                                                </div>
                                        </div>
                
                                        <div class="text-xs font-weight-bold text-info mb-1 mt-n3 mb-2">
                                            <span style="font-size:18px">Description</span>
                                        </div>
                                       <div class="mt-n1 text-muted" style="font-size:14.5px">
                                            {{ $groupe->description }}
                                       </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"></div>
                                      </div>
                                      <div class="col-auto" style="position:absolute;left:77%;top:24%">
                                        <i class="fas fa-comments " style="font-size:90px; color:rgba(221, 223, 235, 0.5)"></i>
                                      </div>
                                    </div>
                                  </div>
                
                                  <a href="{{ route('chat.index',['project_id'=>$project->id, 'groupe_id'=>$groupe->id]) }}">
                                        <div class="card-footer text-center" style="cursor:pointer;  border-bottom-left-radius: 0px; background-color:#4E73DF">
                                              <div class="h5 mb-0 text-white" style="font-size:18px">
                                                
                                                  <i class="fa fa-arrow-right mr-1 text-white" style="font-size:16.5px"></i>
                                                  Entrer
                                                        
                                              </div>
                                          </div>
                                      </a> 
                                    
                                </div>
                              </div>
                    @endforeach
                @endforeach




              @endif

        
        
        



</div>
@if((Auth()->user()->isProductOwner($project->id)))
<div class="mt-4 text-primary">
                {{ $groupes->links() }}
</div>
@endif




@endif


<!-- Modal -->
<div class="modal fade" id="createChat" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
            <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Groupe de discussion</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
        
    <form action="{{ route('chat.create',$project->id) }}" method="POST">
     @csrf
        <div class="container p-0">
                <div class="row justify-content-center">
                    <div class="col-sm-9 px-2 py-4">
                                            <div class="form-group">
                                                    <label for="nom">Titre</label>
                                                    <input type="text" class="form-control" id="nom" name="titre" required>
                                            </div>

                                            <div class="form-group">
                                                    <label for="exampleFormControlTextarea1">Description</label>
                                                    <textarea class="form-control" id="description" name="description" rows="2"></textarea>
                                            </div>


                                    <div class="row">
                                        <div class="col-md-12">
                                                <div id="add" class="btn btn-outline-primary" style="width:100%">Ajouter développeur</div>
                                        </div>
                                    </div>
    
                                    <table class="table" id="dynamicTable">  
                                            <tr>  
                                                    <td>
                                                            <select id="select0" class="form-control" name="select[0]" required>
                                                              <option value="" disabled selected hidden>Choisissez développeur</option>
                                                              @foreach ($project->projectDevelopers as $d)
                                                                    <option class="iter">{{ $d->name }}</option>
                                                              @endforeach
                                                             </select>
                                                    </td>
                                            </tr> 
                                    </table> 
    
                           
                    </div>
                </div>
            </div>

                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-primary">Créer groupe de discussion</button>
                  </div>
            </form>
      </div>
  </div>
</div>



         <!-- Modal -->
         <div class="modal fade" id="deleteGroupe" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Effacer groupe de discussion</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">      
                        Êtes-vous sur?
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Non</button>
                      <form action="{{ route('groupe.delete',$project->id) }}" method="POST">
                          @csrf
                          <button type="submit" class="btn btn-primary" >Oui</button>
                          <input type="text" name="groupeId" id="groupeId" hidden>
                          </form>
                    </div>
                  </div>
                </div>
              </div>

@endsection







@section('js')
<script>
  setTimeout(function() {
    location.reload();
  }, 10000);
</script>

<script type="text/javascript">

   
    var i = 0;

    var iter = $('.iter').length;


    $("#add").click(function(){

if(iter>i+1)
{
++i;
$("#dynamicTable").append('<tr id="tr'+i+'">  <td id="td'+i+'"> </td>    <td id="tdd'+i+'"> </td>    <td id="tdr'+i+'"> </td>   </tr>');
$("#select0").clone().attr('name','select['+i+']').attr('id','select'+i).appendTo("#td"+i);
$("#tdr"+i).append('<button type="button" class="btn btn-danger remove-tr">Remove</button>');
}
else{
 window.alert("Il y a seulement "+iter+" développeurs dans ce projet");
}


});




$(document).on('click', '.remove-tr', function(){  
  --i;
    $(this).parents('tr').remove();
}); 



$('#deleteGroupe').on('show.bs.modal', function (event) {
          var button = $(event.relatedTarget) // Button that triggered the modal
          var id = button.data('id') // Extract info from data-* attributes
          // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
          // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
          $("#groupeId").val(id);
        })
    
   
</script>
      
@endsection