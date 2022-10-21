@extends('layouts.admin',['projectId'=>$project->id])

@section('projectName')
    {{$project->name}}
@endsection
    
@section('content')
@if($sprint->count()===0)
  <div class="container">
      <div class="centered text-center">
          <img src="{{ asset('assets/empty-box.png') }}" alt="aucun sprint" style="width:30%" class="mb-2">
          <h3 class="text-muted">Il y a aucun Sprint pour l'instant</h3>
          @if((Auth()->user()->isProductOwner($project->id)))
            <div class="mt-3 bg-white" style="display:inline-block">
              <a href="{{ route('sprint.open',$project->id) }}" class="btn btn-outline-dark pull-right" style="font-size:14.5px"><i class="fa fa-plus"></i> Créer Sprint</a>
            </div>
          @endif
      </div>
  </div>
@else
    <div class="container">



            @if((Auth()->user()->isProductOwner($project->id)))
            <div class="mb-3 bg-white" style="display:inline-block">
              <a href="{{ route('sprint.open',$project->id) }}" class="btn btn-outline-dark pull-right" style="font-size:14.5px"><i class="fa fa-plus"></i> Créer Sprint</a>
            </div>
            @endif

        <div class="row">
          <div class="col-sm-7">
            <div class="row">
              
                  @foreach ($sprint as $spr )
                  <div class="col-sm-12">
                  @if(($spr->phase ==="undone") || ($spr->phase ==="done"))
                  
                          <div class="box bg-white mb-3" style="border:1px solid #3490DC;">
                              <div class="container p-0">
                                  <div data-target="#text{{$spr->id}}" data-toggle="collapse" aria-selected="true" style="cursor: pointer;">
                                      <div class="bg-primary px-2 pt-2 pb-2" >
                                          <h2 class="d-inline ml-2" style="font-size:19px">{{ $spr->name }}</h2>

                                          @if($spr->phase ==="done")
                                          <span class="badge badge-success ml-2" style="font-size:16px; position:relative;background-color:rgba(2, 166, 24,0.8)">Terminé</span>
                                          @endif
          
                                          @if((Auth()->user()->isProductOwner($project->id)) )
                                          <h2 class="d-inline" style="font-size:15px;float:right;margin-top:3px;margin-right:25px">{{ $spr->time }}</h2>
                                          @else
                                          <h2 class="d-inline" style="font-size:15px;float:right;margin-top:3px">{{ $spr->time }}</h2>
                                          @endif
                                      </div>
                                  </div>
          
                                  @if((Auth()->user()->isProductOwner($project->id))  && !$spr->actif() && $spr->phase())
                                          <button  class="btn btn-labeled btn-primary ml-3" style="background:rgba(46,107,169,0.75); position:absolute;top:6.5px;left:350px" aria-hidden="true" data-id="{{ $spr->id }}" data-toggle="modal" data-target="#startSprint">
                                              <i class="fas fa-play-circle btn-label"></i>
                                              Lancer
                                          </button>
                                  @endif
          
                                  @if((Auth()->user()->isProductOwner($project->id)) )
                                          <i class="fa fa-times" style="font-size:21px;float:right;margin-top:-41px; margin-right:3px; color:#F86959;cursor:pointer" aria-hidden="true" data-id="{{ $spr->id }}" data-toggle="modal" data-target="#deleteSprint"></i>
                                  @endif
                                  <div class="collapse show" id="text{{$spr->id}}" >
                                  <div class="pt-2 pb-2 pt-1">
                                          <div class="box-body px-2 py-1 mb-2">
                                                  <!-- See dist/js/pages/dashboard.js to activate the todoList plugin -->
                                                  <ul class="todo-list">
                                                      @foreach ($spr->userStories as $u )
                                                      <li class="sortable">
                                                          <!-- drag handle -->
                                                          <span class="">
                                                                <h5 class="d-inline"> {{ $loop->iteration }}</h5>
                                                          </span>
                                                          <!-- todo text -->
                                                          <span class="text" style="font-size:14.5px">{{ $u->description }}</span>
                                                          <img src="{{ $u->developer->hasPicture()?asset('storage/'.$u->developer->getPicture()) : $u->developer->getCheckedGravatar()   }}" class="ml-3" alt="Photo de profile"style="border-radius:50%;width:20px;height:20px">
                                                          <span class="" style="font-size:13px;font-family: system-ui;">{{ $u->developer->name }}</span>
                                                     </li>
                                                      @endforeach
                                                  </ul>
                                          </div>
                                          
                                          <ul class="todo-list">
                                                  @foreach ($spr->coments as $coment )
                                                  <li>
                                                          <div class="" style="background-color:whitesmoke" >
                                                                  <img src="{{ $coment->developer->hasPicture()?asset('storage/'.$coment->developer->getPicture()) : $coment->developer->getCheckedGravatar()   }}" class="ml-3" alt="Photo de profile"style="border-radius:50%;width:19px;height:19px">
                                                                  <span class="" style="font-size:12px;font-family: system-ui;">{{ $coment->developer->name }}</span>
                                                                  <span class="text-muted" style="font-size:12px">- {{ $coment->created_at->format('d M') }}</span>
                                                                  <span style="font-size:16px">:</span>
                                                                  <div style="font-size:15px" class="ml-2 d-inline">{{ $coment->text }}</div>
                                                                  @if((Auth()->user()->isProductOwner($project->id)) || Auth()->user()->id === $coment->developer->id )
                                                                  <div class="tools">
                                                                          <i class="far fa-trash-alt"style="font-size:17px" data-id="{{ $coment->id }}" data-toggle="modal" data-target="#delete" ></i>
                                                                  </div>
                                                                  @endif
                                                          </div>
                                                  </li>
                                                  
                                                  @endforeach
                                          </ul>
                                      
                                          @if((Auth()->user()->isProductOwner($project->id)) || Auth()->user()->verifyDeveloper($spr->id) )
                                          <form class=" px-2 py-1" action="{{ route('sprint.comment',['project_id'=>$project->id, 'sprint_id'=>$spr->id]) }}" method="POST">         
                                              @csrf
                                                  <input type="text" name="comment" id="comment" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Ecrire note...">
                                                  <button type="submit" class="btn btn-sm btn-primary ml-1 mt-1">Ajouter</button>
                                          </form>
                                          @endif
                                          
          
          
          
                                  </div>
                              </div>
                          </div>
                      </div>
                      
                 
          
                  @endif
                 </div>
                  @endforeach
              
            </div>
            
          </div>

          <div class="col-sm-5">
              @foreach ($sprint as $spr)
              @if ($spr->phase ==="actif")
              <div style="position:fixed;width:31%" class="fixed-content">
  
                  <div class="card">
                      <div class="card-header">
                        <h3 style="font-size:23px" class="m-0 d-inline mr-2 ">{{ $spr->name }}</h3>
                        <small class="badge badge-success text-white" style="font-size:15px;position:relative;bottom:2px">Actif</small>
                      </div>
                      <div class="card-body pt-3">
                        <div class="text-center">
                            <h4 style="font-size:19px " class="d-inline mr-2">Temps restant:</h4>
                            <span class="text-secondary" style="font-size:18px; font-weight:bold">{{ $spr->dayDiff }} J</span>
                            <span class="text-secondary" style="font-size:18px; font-weight:bold">{{ $spr->hourDiff }} H</span>
                            <span class="text-secondary" style="font-size:18px; font-weight:bold">{{ $spr->minuteDiff }} M</span>
                        </div>
                        <ul class="todo-list">
                        @foreach ($spr->userStories as $userStory)
                        @if($userStory->phase==="between")
                        <li class="sortable">
                            <!-- drag handle -->
                            <span class="handle">
                                  <h5> {{ $loop->iteration }}</h5>
                                </span>
                            <!-- checkbox -->
                            <form id="formname" action="{{ route('userStory.doneSprint',$project->id) }}" method="POST" class="d-inline">
                                  @csrf
                              <input type="text" value="{{ $userStory->id }}" name="userStoryId" hidden>
                          @if((Auth()->user()->id === $userStory->developer_id))
                          <input type="checkbox" onclick="this.form.submit();" >
                          @else
                          <input type="checkbox" disabled >
                          @endif
                            </form>
                            <!-- todo text -->
                            <span class="text" >{{ $userStory->description }}</span>
                            <!-- Emphasis label -->
                         <small class="badge badge-warning text-muted"><i class="fa fa-clock-o"></i>En cours</small>
                         <img src="{{ $userStory->developer->hasPicture()?asset('storage/'.$userStory->developer->getPicture()) : $userStory->developer->getCheckedGravatar()   }}" class="ml-3" alt="Photo de profile"style="border-radius:50%;width:20px;height:20px">
                         <span class="" style="font-size:13px;font-family: system-ui;">{{ $userStory->developer->name }}</span>
                          </li>

                          @elseif($userStory->phase==="done")
                          <li class="sortable">
                              <!-- drag handle -->
                              <span class="handle">
                                    <h5> {{ $loop->iteration }}</h5>
                                  </span>
                              <!-- checkbox -->
                              <form id="formname" action="{{ route('userStory.undoneSprint',$project->id) }}" method="POST" class="d-inline">
                                  @csrf
                              <input type="text" value="{{ $userStory->id }}" name="userStoryId" hidden>
                            
                              @if((Auth()->user()->id === $userStory->developer_id))
                              <input type="checkbox" onclick="this.form.submit();" checked>
                              @else
                              <input type="checkbox" disabled checked>
                              @endif
          
                            </form>
                              <!-- todo text -->
                              <span class="text text-muted" style="text-decoration:line-through;font-size:14px">{{ $userStory->description }}</span>
                              <!-- Emphasis label -->
                           <small class="badge badge-success"><i class="fa fa-clock-o"></i>Terminé</small>
                           <img src="{{ $userStory->developer->hasPicture()?asset('storage/'.$userStory->developer->getPicture()) : $userStory->developer->getCheckedGravatar()   }}" class="ml-3" alt="Photo de profile"style="border-radius:50%;width:20px;height:20px">
                           <span class="" style="font-size:13px;font-family: system-ui;">{{ $userStory->developer->name }}</span>
                            </li>
                          @endif
                          @endforeach
                        </ul>

                        <ul class="todo-list">
                            @foreach ($spr->coments as $coment )
                            <li>
                                    <div class="" style="background-color:whitesmoke" >
                                            <img src="{{ $coment->developer->hasPicture()?asset('storage/'.$coment->developer->getPicture()) : $coment->developer->getCheckedGravatar()   }}" class="ml-3" alt="Photo de profile"style="border-radius:50%;width:19px;height:19px">
                                            <span class="" style="font-size:12px;font-family: system-ui;">{{ $coment->developer->name }}</span>
                                            <span class="text-muted" style="font-size:12px">- {{ $coment->created_at->format('d M') }}</span>
                                            <span style="font-size:16px">:</span>
                                            <div style="font-size:15px" class="ml-2 d-inline">{{ $coment->text }}</div>
                                            @if((Auth()->user()->isProductOwner($project->id)) || Auth()->user()->id === $coment->developer->id )
                                            <div class="tools">
                                                    <i class="far fa-trash-alt"style="font-size:17px" data-id="{{ $coment->id }}" data-toggle="modal" data-target="#delete" ></i>
                                            </div>
                                            @endif
                                    </div>
                            </li>
                            
                            @endforeach
                    </ul>
                
                    @if((Auth()->user()->isProductOwner($project->id)) || Auth()->user()->verifyDeveloper($spr->id) )
                    <form class=" px-2 py-1" action="{{ route('sprint.comment',['project_id'=>$project->id, 'sprint_id'=>$spr->id]) }}" method="POST">         
                        @csrf
                            <input type="text" name="comment" id="comment" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Ecrire note...">
                            <button type="submit" class="btn btn-sm btn-primary ml-1 mt-1">Ajouter</button>
                    </form>
                    @endif
                      
                      </div>
                    </div>
  
              </div>
              @endif
              @endforeach
          </div>
          
        </div>    
        


       
        
    </div>






     <!-- Modal -->
     <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Effacer Commentaire</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">      
                    Êtes-vous sur?
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Non</button>
                  <form action="{{ route('comment.delete',$project->id) }}" method="POST">
                      @csrf
                      <button type="submit" class="btn btn-primary" >Oui</button>
                      <input type="text" name="commentId" id="commentId" hidden>
                      </form>
                </div>
              </div>
            </div>
          </div>






             <!-- Modal -->
     <div class="modal fade" id="deleteSprint" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Effacer Sprint</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">      
                    Êtes-vous sur?
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Non</button>
                  <form action="{{ route('sprint.delete',$project->id) }}" method="POST">
                      @csrf
                      <button type="submit" class="btn btn-primary" >Oui</button>
                      <input type="text" name="sprId" id="sprId" hidden>
                      </form>
                </div>
              </div>
            </div>
          </div>


          <!-- Modal -->
          <div class="modal fade" id="startSprint" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Lancer Sprint</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">      
                    Êtes-vous sur?
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Non</button>
                  <form action="{{ route('sprint.start',$project->id) }}" method="POST">
                      @csrf
                      <button type="submit" class="btn btn-primary" >Oui</button>
                      <input type="text" name="id" id="sid" hidden>
                      </form>
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
          $("#commentId").val(id);
        })

        $('#deleteSprint').on('show.bs.modal', function (event) {
          var button = $(event.relatedTarget) // Button that triggered the modal
          var id = button.data('id') // Extract info from data-* attributes
          // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
          // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
          $("#sprId").val(id);
        })

        $('#startSprint').on('show.bs.modal', function (event) {
          var button = $(event.relatedTarget) // Button that triggered the modal
          var id = button.data('id') // Extract info from data-* attributes
          // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
          // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
          $("#sid").val(id);
        })
      
        
      </script>
      
      @endsection