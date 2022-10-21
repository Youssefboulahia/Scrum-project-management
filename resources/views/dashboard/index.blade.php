@extends('layouts.admin',['projectId'=>$project->id])

@section('projectName')
    {{$project->name}}
@endsection
    
@section('content')

@if($userStories->count()===0)
  <div class="container">
      <div class="centered text-center">
          <img src="{{ asset('assets/empty-box.png') }}" alt="aucun sprint" style="width:26%" class="mb-2">
          <h3 class="text-muted">Il y a aucun User Story pour l'instant</h3>
          @if((Auth()->user()->isProductOwner($project->id)))
            <div class="mt-3 bg-white" style="display:inline-block">
                <button type="button" class="btn btn-outline-dark pull-right"data-toggle="modal" data-target="#createUserStory" style="font-size:14.5px"><i class="fa fa-plus"></i> Créer User Story</button>
            </div>
          @endif
      </div>
  </div>



    <!--MODAL-->
    <div class="modal fade" id="createUserStory" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">New message</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
            <form action="{{route('userStory.store',$project->id)}}" method="POST">
                @csrf

                <div class="form-group">
                  <label for="description" class="col-form-label">User Story:</label>
                  <textarea type="text" class="form-control" id="description" name="description">En tant que </textarea>
                </div>
                <div class="form-group">
                        <label for="priorité">Priorité:</label>
                        <select class="form-control" id="priorité" name="priorité">
                          <option>Faible</option>
                          <option>Moyen</option>
                          <option>Élevé</option>
                        </select>
                </div>
                <div class="form-group">
                        <label for="éstimation" class="col-form-label">Éstimation:</label>
                        <input type="number" class="form-control" id="éstimation" name="éstimation">
                </div>
              
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Ajouter</button>
            </div>
           </form>
          </div>
        </div>
      </div>





@else
     <!-- TO DO List -->
     <div class="box bg-white py-3" style="padding:10px;box-shadow: 1px 1px 5px rgba(0,0,0,.2);">
         <div class="container">
        <div class="box-header">
          <i class="ion ion-clipboard"></i>

          <h4 class="box-title">La liste des User Story:</h4>

        </div>
        <!-- /.box-header -->
        <div class="box-body mt-3">
          <!-- See dist/js/pages/dashboard.js to activate the todoList plugin -->
          <ul class="todo-list">
                @foreach ($userStories as $userStory)
                @if($userStory->phase==="done")
                <li class="sortable">
                      <!-- drag handle -->
                      <span class="handle">
                            <h5> {{ $loop->iteration }}</h5>
                          </span>
                      <!-- checkbox -->
                      <form id="formname" action="{{ route('userStory.undone',$project->id) }}" method="POST" class="d-inline">
                            @csrf
                        <input type="text" value="{{ $userStory->id }}" name="userStoryId" hidden>
                      
                        @if((Auth()->user()->isProductOwner($project->id)))
                        <input type="checkbox" onclick="this.form.submit();" checked>
                        @else
                        <input type="checkbox" disabled checked>
                        @endif
    
                      </form>
                      <!-- todo text -->
                      <span class="text text-muted" style="text-decoration:line-through;font-size:14px">{{ $userStory->description }}</span>
                      <!-- Emphasis label -->
                      <small class="badge badge-secondary"><i class="fas fa-clock"></i> {{ $userStory->created_at->format('d M') }}</small>
                      <!-- Emphasis label -->
                      <small class="badge badge-success"><i class="fa fa-clock-o"></i>Terminé</small>
                      <!-- General tools such as edit or delete-->
                      <div class="tools">
                            <i class="fa fa-eye text-primary"style="font-size:19px"data-description="{{ $userStory->description }}" data-priorité="{{ $userStory->priority }}" data-estimation="{{ $userStory->estimation }}"data-phase="{{ $userStory->phase }}"data-toggle="modal" data-target="#show"></i>
                      </div>
                    </li>

                    @elseif($userStory->phase==="undone")
                    <li class="sortable">
                          <!-- drag handle -->
                          <span class="handle">
                                <h5> {{ $loop->iteration }}</h5>
                              </span>
                          <!-- checkbox -->
                          <form id="formname" action="{{ route('userStory.done',$project->id) }}" method="POST" class="d-inline">
                                @csrf
                            <input type="text" value="{{ $userStory->id }}" name="userStoryId" hidden>
                            @if((Auth()->user()->isProductOwner($project->id)))
                        <input type="checkbox" onclick="this.form.submit();" >
                        @else
                        <input type="checkbox" disabled >
                        @endif
                          </form>
                          <!-- todo text -->
                          <span class="text">{{ $userStory->description }}</span>
                          <!-- Emphasis label -->
                          <small class="badge badge-primary"><i class="fas fa-clock"></i> {{ $userStory->created_at->format('d M') }}</small>
                          <!-- General tools such as edit or delete-->
                          <div class="tools">
                                @if((Auth()->user()->isProductOwner($project->id)))
                                <i class="fa fa-eye text-primary"style="font-size:19px"data-description="{{ $userStory->description }}" data-priorité="{{ $userStory->priority }}" data-estimation="{{ $userStory->estimation }}"data-phase="{{ $userStory->phase }}"data-toggle="modal" data-target="#show"></i>
                                <i class="fa fa-edit text-info"style="font-size:19px" data-id="{{ $userStory->id }}" data-description="{{ $userStory->description }}" data-priorité="{{ $userStory->priority }}" data-estimation="{{ $userStory->estimation }}"data-toggle="modal" data-target="#edit"></i>
                                <i class="far fa-trash-alt"style="font-size:19px" data-id="{{ $userStory->id }}" data-toggle="modal" data-target="#delete"></i>
                                @else
                                <i class="fa fa-eye text-primary"style="font-size:19px"data-description="{{ $userStory->description }}" data-priorité="{{ $userStory->priority }}" data-estimation="{{ $userStory->estimation }}"data-phase="{{ $userStory->phase }}"data-toggle="modal" data-target="#show"></i>
                                @endif
                          </div>
                        </li>


                        @elseif($userStory->phase==="between")
                    <li class="sortable">
                          <!-- drag handle -->
                          <span class="handle">
                                <h5> {{ $loop->iteration }}</h5>
                              </span>
                          <!-- checkbox -->

                        <input type="checkbox" disabled >
                          </form>
                          <!-- todo text -->
                          <span class="text">{{ $userStory->description }}</span>
                          <!-- Emphasis label -->
                          <small class="badge badge-primary"><i class="fas fa-clock"></i> {{ $userStory->created_at->format('d M') }}</small>
                          <!-- Emphasis label -->
                         <small class="badge badge-warning text-muted"><i class="fa fa-clock-o"></i>En cours</small>
                          <!-- General tools such as edit or delete-->
                          <div class="tools">
                                <i class="fa fa-eye text-primary"style="font-size:19px"data-description="{{ $userStory->description }}" data-priorité="{{ $userStory->priority }}" data-estimation="{{ $userStory->estimation }}"data-phase="{{ $userStory->phase }}"data-toggle="modal" data-target="#show"></i>
                          </div>
                        </li>




                        @endif

              @endforeach
          </ul>
        </div>
        <!-- /.box-body -->
        @if((Auth()->user()->isProductOwner($project->id)))
        <div class="box-footer clearfix no-border mt-3">
          <button type="button" class="btn btn-outline-dark pull-right"data-toggle="modal" data-target="#createUserStory" style="font-size:13.5px"><i class="fa fa-plus"></i> Créer User Story</button>
        </div>
        @endif
    </div>
      </div>
      <!-- /.box -->

      





      <!--MODAL-->
      <div class="modal fade" id="createUserStory" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">New message</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                <form action="{{route('userStory.store',$project->id)}}" method="POST">
                    @csrf

                    <div class="form-group">
                      <label for="description" class="col-form-label">User Story:</label>
                      <textarea type="text" class="form-control" id="description" name="description">En tant que </textarea>
                    </div>
                    <div class="form-group">
                            <label for="priorité">Priorité:</label>
                            <select class="form-control" id="priorité" name="priorité">
                              <option>Faible</option>
                              <option>Moyen</option>
                              <option>Élevé</option>
                            </select>
                    </div>
                    <div class="form-group">
                            <label for="éstimation" class="col-form-label">Éstimation:</label>
                            <input type="number" class="form-control" id="éstimation" name="éstimation">
                    </div>
                  
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Ajouter</button>
                </div>
               </form>
              </div>
            </div>
          </div>

          <!--/MODAL-->




            <!--MODAL-->
      <div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">New message</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                <form action="{{route('userStory.update',$project->id)}}" method="POST">
                    @csrf

                    <div class="form-group">
                      <label for="description" class="col-form-label">User Story:</label>
                      <textarea type="text" class="form-control" id="editdes" name="description">En tant que </textarea>
                    </div>
                    <div class="form-group">
                            <label for="priorité">Priorité:</label>
                            <select class="form-control" id="editprio" name="priorité">
                              <option>Faible</option>
                              <option>Moyen</option>
                              <option>Élevé</option>
                            </select>
                    </div>
                    <div class="form-group">
                            <label for="éstimation" class="col-form-label">Éstimation:</label>
                            <input type="number" class="form-control" id="edites" name="éstimation">
                    </div>

                    <input type="text" name="userStoryId" id="editUserStoryId" hidden >
                  
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                  <button type="submit" class="btn btn-primary">Modifer</button>
                </div>
               </form>
              </div>
            </div>
          </div>

          <!--/MODAL-->





           <!-- Modal -->
           <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Effacer User Story</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">      
                        Êtes-vous sur?
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Non</button>
                      <form action="{{ route('userStory.delete',$project->id) }}" method="POST">
                          @csrf
                          <button class="btn btn-primary" >Oui</button>
                          <input type="text" name="userStoryId" id="userStoryId" hidden>
                          </form>
                    </div>
                  </div>
                </div>
              </div>




              <!-- Modal -->
           <div class="modal fade" id="show" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">User Story</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">      
                        
                        <div class="container p-2">
                            <div class="row align-items-center my-3">
                                <div class="col-sm-3 text-dark" style="font-size:16px;font-weight:bold">Description:</div>
                                <div class="col-sm-9"><p id="des" class="d-inline"></p></div>
                            </div>

                            <div class="row align-items-center my-3">
                                <div class="col-sm-3 text-dark" style="font-size:16px;font-weight:bold">Priorité:</div>
                                <div class="col-sm-9"><p id="prio" class="d-inline"></p></div>
                            </div>

                            <div class="row align-items-center my-3">
                                    <div class="col-sm-3 text-dark" style="font-size:16px;font-weight:bold">Éstimation:</div>
                                    <div class="col-sm-9"><p id="es" class="d-inline"></p></div>
                            </div>

                            <div class="row align-items-center my-3">
                                    <div class="col-sm-3 text-dark" style="font-size:16px;font-weight:bold">Progrès:</div>
                                    <div class="col-sm-9"><p id="phase" class="d-inline"></p></div>
                            </div>

                            <div class="row align-items-center my-3">
                                    <div class="col-sm-3 text-dark" style="font-size:16px;font-weight:bold">Créateur:</div>
                                    <div class="col-sm-9"><p class="d-inline">{{ $project->productOwner->name }}</p></div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                    </div>
                  </div>
                </div>
              </div>
      @endif
    
@endsection

@section('js')
              

<script>
  $('#delete').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var id = button.data('id') // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    $("#userStoryId").val(id);
  })

  $('#show').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var description = button.data('description') // Extract info from data-* attributes
    var priorité = button.data('priorité') // Extract info from data-* attributes
    var estimation = button.data('estimation') // Extract info from data-* attributes
    var phase = button.data('phase') // Extract info from data-* attributes
    if(phase==="undone")
    {
        phase="Pas encore terminé";
    }
    else if(phase==="between")
    phase="En cours";
    else
    {
        phase="Terminé";
    }
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    $("#des").text(description);
    $("#prio").text(priorité);
    $("#es").text(estimation);
    $("#phase").text(phase);
  })

  $('#edit').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var description = button.data('description') // Extract info from data-* attributes
    var priorité = button.data('priorité') // Extract info from data-* attributes
    var estimation = button.data('estimation') // Extract info from data-* attributes
    var id = button.data('id') // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    $("#editdes").val(description);
    $("#editprio").val(priorité);
    $("#edites").val(estimation);
    $("#editUserStoryId").val(id);
  })
  

  
</script>

@endsection