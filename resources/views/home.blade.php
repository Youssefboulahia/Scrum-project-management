@extends('layouts.app')
@section('content')


    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    @if (session()->has('error'))
        <div class="alert alert-danger">{{ session()->get('error') }}</div>
    @endif

    @if (session()->has('invitationAnnuler'))
        <div class="alert alert-danger">{{ session()->get('invitationAnnuler') }}</div>
    @endif

    @if (session()->has('exist'))
        <div class="alert alert-danger">{{ session()->get('exist') }}</div>
    @endif

    @if (session()->has('invitationAccepter'))
        <div class="alert alert-success">{{ session()->get('invitationAccepter') }}</div>
    @endif

    
    <div class="container text-center my-5">
        <button  class="btn btn-primary py-10 px-5"  data-toggle="modal" data-target="#createProject">Créer Projet</button>
    </div>


    <!-- Modal -->
<div class="modal fade" id="createProject" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Créer un projet</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{route('project.store')}}" method="post">
            @csrf
        <div class="modal-body">
          
                <div class="form-group">
                  <label for="exampleInputEmail1">Groupe du projet</label>
                  <input type="text" class="form-control" name="group" placeholder="Nom groupe">
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Nom du projet</label>
                  <input type="text" class="form-control" name="name" placeholder="Nom projet">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Description du projet</label>
                    <textarea type="text" class="form-control" name="description" placeholder="Description projet"></textarea>
                  </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
          <button type="submit" class="btn btn-primary">Sauvegarder</button>
        </div>
      </form>
      </div>
    </div>
  </div>










   <div class="container-fluid ">
        <div class="row  mx-lg-n2 ">
                <div class="col-md-4 px-lg-4">
                               <div class="text-center p-2 mb-3" style="background-color:#fff;box-shadow: 0 0 1px rgba(0, 0, 0, 0.125), 0 1px 3px rgba(0, 0, 0, 0.2);letter-spacing:.13rem;font-weight:bold; font-size:1.3rem">
                                  Travail
                                </div>

                                @foreach (Auth()->user()->userStories as $us)
                                <div class="card">
                                    <div class="card-body">
                                      <h5 class="card-title">Projet: {{ $us->project->name }}</h5>
                                      <p class="card-text">{{ $us->description }}</p>
                                      <a href="{{route('dashboard.sprint', $us->project->id )}}" class="btn btn-sm btn-primary">Aller vers le projet</a>
                                    </div>
                                  </div>
                                @endforeach
                                
                                      </div>
                                    <div class="col-md-4 px-lg-4">

                                        <div class="text-center p-2 mb-3" style="background-color:#fff;box-shadow: 0 0 1px rgba(0, 0, 0, 0.125), 0 1px 3px rgba(0, 0, 0, 0.2);letter-spacing:.13rem;font-weight:bold; font-size:1.3rem">
                                                Invitations
                                        </div>



                                        <div class="card" role="tablist">
                                          <div class="card-header" role="tab" data-target="#invitationEnvoyee" data-toggle="collapse" aria-selected="true" style="cursor:pointer;">
                                              
                                                 <h4 style="font-size:19px">Invitations Envoyée: {{ Auth()->user()->getSendedInvitations()->count() }}</h4>
                                            
                                          </div>
                                          <div class="collapse show" id="invitationEnvoyee" role="tabpanel">
                                              <div class="card-body">
                                                @foreach (Auth()->user()->getSendedInvitations() as $invitation)
                                                <div class="info-box">
                                                  <span class="info-box-icon"><img  src="{{$invitation->getDeveloper($invitation->developer_id)->hasPicture()? asset('storage/'.$invitation->getDeveloper($invitation->developer_id)->getPicture()) : $invitation->getDeveloper($invitation->developer_id)->getCheckedGravatar()   }}" alt=""></span>
                                                  <div class="info-box-content">
                                                    <span class="info-box-text">{{ $invitation->getDeveloper($invitation->developer_id)->email }}</span>
                                                    <span class="progress-description">
                                                      <strong>Nom du Projet:</strong> {{ $invitation->getProject($invitation->project_id)->name}}
                                                    </span>
                                                    <button class="btn btn-outline-dark"style="font-size:10px;"data-id="{{ $invitation->id }}" data-toggle="modal" data-target="#annulermodal">Annuler invitation</button>                                       
                                                   
                                                  </div>
                                                </div>
                                           @endforeach
                                             </div>
                                          </div>
                                      </div>



                                               <!-- Modal -->
                                               <div class="modal fade" id="annulermodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                  <div class="modal-content">
                                                    <div class="modal-header">
                                                      <h5 class="modal-title" id="exampleModalLabel">Annuler l'invitation</h5>
                                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                      </button>
                                                    </div>
                                                    <div class="modal-body">      
                                                        Êtes-vous sur?
                                                    </div>
                                                    @if(count(Auth()->user()->getSendedInvitations())>0)
                                                    <div class="modal-footer">
                                                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                      <form action="{{ route('invitation.annuler') }}" method="POST">
                                                          @csrf
                                                          <button class="btn btn-primary" >Annuler l'invitation</button>
                                                          <input type="text" name="invitationId" id="invitationId" hidden>
                                                          </form>
                                                    </div>
                                                    @endif
                                                  </div>
                                                </div>
                                              </div>



                                      

                                      <div class="card" role="tablist">
                                        <div class="card-header" role="tab" data-target="#invitationrecu" data-toggle="collapse" aria-selected="true"style="cursor:pointer;">
                                            
                                               <h4 style="font-size:19px">Invitation Reçue:  {{ Auth()->user()->getRecievedInvitations()->count() }}</h4>
                                          
                                        </div>
                                        <div class="collapse show" id="invitationrecu" role="tabpanel">
                                            <div class="card-body">
                                              @foreach (Auth()->user()->getRecievedInvitations() as $invitation)
                                            <div class="info-box">
                                              <span class="info-box-icon"><img  src="{{$invitation->getProductOwner($invitation->productOwner_id)->hasPicture()? asset('storage/'.$invitation->getProductOwner($invitation->productOwner_id)->getPicture()) : $invitation->getProductOwner($invitation->productOwner_id)->getCheckedGravatar()   }}" alt="" ></span>
                                              <div class="info-box-content">
                                                <span class="info-box-text">{{ $invitation->getProductOwner($invitation->productOwner_id)->email }}</span>
                                                <span class="progress-description">
                                                  <strong>Nom du Projet:</strong> {{ $invitation->getProject($invitation->project_id)->name}}
                                                </span>
                                                <button class="btn btn-success "style="font-size:10px;"data-idd="{{ $invitation->id }}" data-toggle="modal" data-target="#acceptermodal">Accepter</button> 
                                                <button class="btn btn-outline-dark "style="font-size:10px;"data-id="{{ $invitation->id }}" data-toggle="modal" data-target="#refusermodal">Refuser</button>
                                              </div>
                                        </div>
                                       
                                        @endforeach
                                           </div>
                                        </div>
                                    </div>




                                     <!-- Modal -->
                                     <div class="modal fade" id="refusermodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                      <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Refuser l'invitation</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                              <span aria-hidden="true">&times;</span>
                                            </button>
                                          </div>
                                          <div class="modal-body">      
                                              Êtes-vous sur?
                                          </div>
                                          @if(count(Auth()->user()->getRecievedInvitations())>0)
                                          <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <form action="{{ route('invitation.annuler') }}" method="POST">
                                                @csrf
                                                <button class="btn btn-primary" >Refuser l'invitation</button>
                                                <input type="text" name="invitationId" id="invitationId" hidden>
                                                </form>
                                          </div>
                                          @endif
                                        </div>
                                      </div>
                                    </div>






                                     <!-- Modal -->
                                   <div class="modal fade" id="acceptermodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <h5 class="modal-title" id="exampleModalLabel">Accepter l'invitation</h5>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                          </button>
                                        </div>
                                        <div class="modal-body">      
                                            Êtes-vous sur?
                                        </div>
                                        @if(count(Auth()->user()->getRecievedInvitations())>0)
                                        <div class="modal-footer">
                                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                          <form action="{{ route('invitation.accepter') }}" method="POST">
                                              @csrf
                                              <button class="btn btn-primary" >Accepter l'invitation</button>
                                              <input type="text" name="invitationIdd" id="invitationIdd" hidden>
                                              </form>
                                        </div>
                                        @endif
                                      </div>
                                    </div>
                                  </div>
                                        
                             
                                       
                </div>
                <div class="col-md-4 px-lg-4">
                                <div class="text-center p-2 mb-3" style="background-color:#fff;box-shadow: 0 0 1px rgba(0, 0, 0, 0.125), 0 1px 3px rgba(0, 0, 0, 0.2);letter-spacing:.13rem;font-weight:bold; font-size:1.3rem">
                                                Projets
                                        </div>

                                        <div class="card" role="tablist">
                                          <div class="card-header" role="tab" data-target="#myProjects" data-toggle="collapse" aria-selected="true" style="cursor:pointer;">
                                              
                                                 <h4 style="font-size:19px">Mes projets crée: {{ $projects->count() }}</h4>
                                            
                                          </div>
                                          <div class="collapse show" id="myProjects" role="tabpanel">
                                              <div class="card-body">
                                                @foreach ($projects as $project)
                                                        <div class="p-10 text-center mb-3">
                                                        <a href="{{route('dashboard.start', $project->id )}}" class="list-group-item list-group-item-action">
                                                                <p><strong>groupe:</strong> {{$project->group}}</p>
                                                                <p><strong>Nom du projet:</strong> {{$project->name}}</p>
                                                                <p><strong>Description:</strong> {{$project->description}}</p>
                                                                <p><strong>Nombre développeur:</strong> {{$project->projectDevelopers()->count()}}</p>    
                                                        </a>
                                                        <button type="button" class="btn btn-primary" data-id="{{ $project->id }}" data-toggle="modal" data-target="#exampleModal">
                                                          Inviter développeur
                                                        </button>
                                                      </div>


                                                @endforeach
                                             </div>
                                          </div>
                                      </div>


                                      
                                      <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                          <div class="modal-content">
                                            <div class="modal-header">
                                              <h5 class="modal-title" id="exampleModalLabel">Inviter un développeur</h5>
                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                              </button>
                                            </div>
                                            @if(count($projects)>0)
                                            <form action="{{ route('invitation.inviter')}}" method="POST">
                                                @csrf
                                            <div class="modal-body">
                                              <div class="row align-items-center">
                                                <div class="col-md-3 offset-md-1">
                                                    <p>L'adresse email du développeur:</p>
                                                </div>
                                                <div class="col-md-7 ">
                                                    <input type="email" class="form-control" name="email">
                                                    <input hidden type="text" class="form-control" name="projectId"  id="projectId">
                                                </div>
                                              </div>
                                            </div>
                                            <div class="modal-footer">
                                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                                              <button type="submit" class="btn btn-primary">Envoyer</button>
                                            
                                            </div>
                                            </form>
                                            @endif
                                          </div>
                                        </div>
                                      </div>







                                      <div class="card" role="tablist">
                                        <div class="card-header" role="tab" data-target="#myProjectsInvited" data-toggle="collapse" aria-selected="true" style="cursor:pointer;">
                                            
                                               <h4 style="font-size:19px">Mes projets invité: {{ $developerProjects->count() }}</h4>
                                          
                                        </div>
                                        <div class="collapse show" id="myProjectsInvited" role="tabpanel">
                                            <div class="card-body">
                                              @foreach ($developerProjects as $project)
                                                      <div class="p-10 text-center mb-3">
                                                      <a href="{{route('dashboard.start', $project->id )}}" class="list-group-item list-group-item-action">
                                                          <p><strong>groupe:</strong> {{$project->group}}</p>
                                                          <p><strong>Nom du projet:</strong> {{$project->name}}</p>
                                                          <p><strong>Description:</strong> {{$project->description}}</p>   
                                                          <p><strong>Product Owner:</strong> {{$project->productOwner->name}}</p> 
                                                      </a>
                                                      </div>
                                              @endforeach
                                           </div>
                                        </div>
                                    </div>




                        


                       
                </div>
        </div>
   </div>
   
   @endsection




          @section('js')
              
         

                <script>
                  $('#exampleModal').on('show.bs.modal', function (event) {
                    var button = $(event.relatedTarget) // Button that triggered the modal
                    var id = button.data('id') // Extract info from data-* attributes
                    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
                    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
                    $("#projectId").val(id);
                  })

                  $('#annulermodal').on('show.bs.modal', function (event) {
                    var button = $(event.relatedTarget) // Button that triggered the modal
                    var id = button.data('id') // Extract info from data-* attributes
                    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
                    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
                    $("#invitationId").val(id);
                  })

                  $('#acceptermodal').on('show.bs.modal', function (event) {
                    var button = $(event.relatedTarget) // Button that triggered the modal
                    var id = button.data('idd') // Extract info from data-* attributes
                    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
                    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
                    $("#invitationIdd").val(id);
                  })

                  $('#refusermodal').on('show.bs.modal', function (event) {
                    var button = $(event.relatedTarget) // Button that triggered the modal
                    var id = button.data('id') // Extract info from data-* attributes
                    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
                    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
                    $("#invitationId").val(id);
                  })

                  

                </script>

@endsection
   

