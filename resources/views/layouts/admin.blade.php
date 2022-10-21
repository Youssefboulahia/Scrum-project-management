<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>Gestion_De_Projet</title>

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href={{url("bower_components/admin-lte/plugins/fontawesome-free/css/all.min.css" )}}>
  <!-- Theme style -->
  <link rel="stylesheet" href={{url("bower_components/admin-lte/dist/css/adminlte.min.css" )}}>

  <link rel="stylesheet" href={{url("bower_components/admin-lte/dist/css/skins.min.css" )}}>

  <link rel="stylesheet" href={{url("css/app.css" )}}>

  <link rel="stylesheet" href="{{ asset('css/notif.css') }}">
  


  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

 

  @yield('css')

  <style>
  .centered {
  position: absolute;
  top: 50%;
  left: 58%;
  /* bring your own prefixes */
  transform: translate(-50%, -50%);
  }
  .btn-label{
    position: relative;
    left:-12px;
    display:inline-block;
    padding:6px 12px;
    border:3px 0px 0px 3px;
    background:rgba(0,0,0,0.15);
  }
  .btn-labeled{
    padding-top:0px;
    padding-bottom:0px;
  }
  .fixed{
    position:fixed !important;
  }
  .border-zero{
    border-top-right-radius: 0px !important ;
    border-bottom-right-radius: 0px !important;
  }
  .inline{
    display: inline !important;
  }

  .fixed-content {
    position: fixed;
    top:72px;
    bottom: 0;
    overflow-y:scroll;
    overflow-x:hidden;
}
  </style>

  <meta name="csrf-token" content="{{ csrf_token() }}" />

</head>



<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <div>

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{route('home')}}" class="nav-link">Accueil</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li>
    </ul>

    

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      
       <!-- Nav Item - Alerts -->
       <li class="nav-item dropdown no-arrow mx-1">
          
          <form id="ajaxform" method="POST" class="d-inline">
          <a id="save-data" class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-bell fa-fw" style="color:#d6d6d6; font-size:19px;margin-right:2px;margin-top:2px"></i>
            <!-- Counter - Alerts -->
            @if(Auth()->user()->notifications()->count() !== 0  &&  Auth()->user()->notificationsChecked()->count() !== 0)
            <span id="badge" class="badge badge-danger badge-counter" style="font-size:12.5px">{{ Auth()->user()->notificationsChecked()->count()  }}</span>
            @endif
          </a>
          

         
          <!-- Dropdown - Alerts -->
          <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in pt-0" aria-labelledby="alertsDropdown">
              <h6 class="dropdown-header">
                Notifications
              </h6>

            
            @if(Auth()->user()->notifications()->count() !== 0)
            
            @foreach (Auth()->user()->notifications() as $notif )

            @if($notif->sprint_id !== null)
                @if($notif->description ==='sprintLancer')
                <a class="dropdown-item d-flex align-items-center pt-2" href="{{ url('dashboard/sprint/'.$projectId )}}">
                    <div class="mr-3">
                      <div class="icon-circle bg-success">
                        <i class="fa fa-play text-white"></i>
                      </div>
                    </div>
                    <div>
                      <div class="small text-gray-500">{{ $notif->created_at->format('d M yy') }}</div>
                      <span>Le Sprint <span style="font-style:italic">«{{ $notif->sprint()->name }}»</span> dont vous être assigné est lancé</span>
                    </div>
                  </a>
                @elseif($notif->description ==='sprintAffecter')
                <a class="dropdown-item d-flex align-items-center pt-2" href="{{ url('dashboard/sprint/'.$projectId )}}">
                    <div class="mr-3">
                      <div class="icon-circle bg-primary">
                        <i class="fas fa-th text-white"></i>
                      </div>
                    </div>
                    <div>
                      <div class="small text-gray-500">{{ $notif->created_at->format('d M yy') }}</div>
                      <span>Vous être assigné au Sprint: <span style="font-style:italic">«{{ $notif->sprint()->name }}»</span></span>
                    </div>
                  </a>

                  @elseif($notif->description ==='sprintDone')
                  <a class="dropdown-item d-flex align-items-center pt-2" href="{{ url('dashboard/sprint/'.$projectId )}}">
                      <div class="mr-3">
                        <div class="icon-circle bg-primary">
                          <i class="fas fa-th text-white"></i>
                        </div>
                      </div>
                      <div>
                        <div class="small text-gray-500">{{ $notif->created_at->format('d M yy') }}</div>
                        <span>{{ $notif->name }} a marqué sont avancement dans le Sprint: <span style="font-style:italic">«{{ $notif->sprint()->name }}»</span></span>
                      </div>
                    </a>

                    @elseif($notif->description ==='sprintUndone')
                    <a class="dropdown-item d-flex align-items-center pt-2" href="{{ url('dashboard/sprint/'.$projectId )}}">
                        <div class="mr-3">
                          <div class="icon-circle bg-danger">
                            <i class="fas fa-th text-white"></i>
                          </div>
                        </div>
                        <div>
                          <div class="small text-gray-500">{{ $notif->created_at->format('d M yy') }}</div>
                          <span>{{ $notif->name }} a marqué sont avancement dans le Sprint: <span style="font-style:italic">«{{ $notif->sprint()->name }}»</span></span>
                        </div>
                      </a>

                      @elseif($notif->description ==='sprintEnd')
                    <a class="dropdown-item d-flex align-items-center pt-2"href="{{ url('dashboard/sprint/'.$projectId )}}">
                        <div class="mr-3">
                          <div class="icon-circle bg-success">
                            <i class="fa fa-flag text-white"></i>
                          </div>
                        </div>
                        <div>
                          <div class="small text-gray-500">{{ $notif->created_at->format('d M yy') }}</div>
                          <span>Le Sprint: <span style="font-style:italic">«{{ $notif->sprint()->name }}» est terminé</span></span>
                        </div>
                      </a>

                      @elseif($notif->description ==='sprintEffacer')
                      <a class="dropdown-item d-flex align-items-center pt-2" href="{{ url('dashboard/sprint/'.$projectId )}}">
                          <div class="mr-3">
                            <div class="icon-circle bg-danger">
                              <i class="fa fa-times text-white"></i>
                            </div>
                          </div>
                          <div>
                            <div class="small text-gray-500">{{ $notif->created_at->format('d M yy') }}</div>
                            <span>Le sprint: <span style="font-style:italic">«{{ $notif->name }}» a été supprimé</span></span>
                          </div>
                        </a>


                        @endif

             @elseif($notif->groupe_id !== null)
             @if($notif->description ==='groupeAffecter')
             <a class="dropdown-item d-flex align-items-center pt-2" href="{{ url('dashboard/groupeDiscussion/'.$projectId )}}">
                <div class="mr-3">
                  <div class="icon-circle bg-info">
                    <i class="fa fa-comments  text-white"></i>
                  </div>
                </div>
                <div>
                  <div class="small text-gray-500">{{ $notif->created_at->format('d M yy') }}</div>
                  <span>Vous être ajouté au groupe de discussion: <span style="font-style:italic">«{{ $notif->groupe()->title }}»</span></span>
                </div>
              </a>
              @elseif($notif->description ==='groupeEffacer')
             <a class="dropdown-item d-flex align-items-center pt-2" href=" href="{{ url('dashboard/groupeDiscussion/'.$projectId )}}"">
                <div class="mr-3">
                  <div class="icon-circle bg-danger">
                    <i class="fa fa-times  text-white"></i>
                  </div>
                </div>
                <div>
                  <div class="small text-gray-500">{{ $notif->created_at->format('d M yy') }}</div>
                  <span>Le groupe de discussion: <span style="font-style:italic">«{{ $notif->name }}» a été supprimé</span></span>
                </div>
              </a>

              @endif

              
              @endif

              <input type="text" hidden value="{{ $notif->id }}" class="notif-id">
            @endforeach

            <a class="dropdown-item text-center small text-gray-500 mt-2" href="#"><i class="fa fa-arrow-down mr-2"></i>Voir encore</a>
            @else
            <div style="height:80px" class="text-center">
              <div style="position:relative; top:20px">
                  <i class="fa fa-bell-slash" aria-hidden="true" style="font-size:25px"></i>
                  <h5 class="text-muted" style="font-size:17px">Aucune notifications</h5>
              </div>     
            </div>
            @endif


          </div>
        </form>
        </li>

        



      <li class="nav-item dropdown">
          <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
              {{ Auth::user()->name }} <span class="caret"></span>
              <img src="{{ Auth()->user()->hasPicture()? asset('storage/'.Auth()->user()->getPicture()) : Auth()->user()->getCheckedGravatar()   }}" class="ml-1 mt-n1" alt="Photo de profile"style="border-radius:50%;width:27px;height:27px">
          </a>

            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">

                <a class="dropdown-item" href="{{ route('profile.index') }}">
                    Profile
                </a>

                <a class="dropdown-item" href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </li>


    </ul>
  </nav>
  <!-- /.navbar -->
</div>

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4 fixed">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link text-center">
     <!-- <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">  -->
           <span class="mr-2 brand-text">PROJET: </span>
      <span class="brand-text font-weight-light">@yield('projectName')</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex"style="justify-content: center">
        <div class="image ml-n4">
            <img src="{{ Auth()->user()->hasPicture()?asset('storage/'.Auth()->user()->getPicture()) : Auth()->user()->getCheckedGravatar()   }}" class="img-circle elevation-2" alt="User Image"> 
        </div>
        <div class="info">
          <a href="#" class="d-block"><span class="brand-text font-weight-light">{{ Auth::user()->name }}</span></a>
        </div>
      </div>

      <div class="user-panel mt-n3 mb-3 d-flex">
          <div class="info">
            <a class="brand-text font-weight-light ml-2" style="font-size:15px;pointer-events: none;cursor: default;">Role:
              @if((Auth()->user()->isProductOwner($projectId)))
                Product Owner 
               @else
                Développeur 
               @endif
              </a>
            
          </div>
        </div>
      

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

          <li class="nav-item ">
            <a href="{{ route('dashboard.start',$projectId) }}" class="{{ (request()->is('dashboard/userStory/'.$projectId)) ? 'nav-link active' : 'nav-link'}}">
              <i class="nav-icon fas fa-tasks"></i>
              <p>
                Product Backlog
              </p>
            </a>
          </li>

          <li class="nav-item">
                <a href="{{ route('dashboard.sprint',$projectId) }}" class="{{ (request()->is('dashboard/sprint/'.$projectId)) || (request()->is('sprint/index/'.$projectId)) ? 'nav-link active' : 'nav-link'}}">
                  <i class="nav-icon fas fa-th"></i>
                  <p>
                    Sprint Backlog
                  </p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{ route('dashboard.fichier',$projectId) }}" class="{{ (request()->is('dashboard/fichier/'.$projectId))  ||   (request()->is('fichier/filtrer/'.$projectId)) ? 'nav-link active' : 'nav-link'}}">
                    <i class="nav-icon fas fas fa-file-alt"></i>
                    <p>
                      Fichiers
                    </p>
                  </a>
                </li>

             @if (isset($groupeId))
             <li class="nav-item">
                <a href="{{ route('dashboard.groupeDiscussion',$projectId) }}" class="{{ (request()->is('dashboard/groupeDiscussion/'.$projectId))   ||   (request()->is('chat/room/'.$projectId.'/'.$groupeId)) ? 'nav-link active' : 'nav-link'}}">
                      <i class="nav-icon fas fa-comments"></i>
                      <p>
                        Groupe de discussion
                      </p>
                    </a>
                  </li>

              @else

              <li class="nav-item">
                  <a href="{{ route('dashboard.groupeDiscussion',$projectId) }}" class="{{ (request()->is('dashboard/groupeDiscussion/'.$projectId))   ? 'nav-link active' : 'nav-link'}}">
                        <i class="nav-icon fas fa-comments"></i>
                        <p>
                          Groupe de discussion
                        </p>
                      </a>
                    </li>
             @endif
              

            
                  <li class="nav-item">
                        <a href="{{ route('dashboard.burndownChart',$projectId) }}" class="{{ (request()->is('dashboard/burndownChart/'.$projectId)) ? 'nav-link active' : 'nav-link'}}">
                          <i class="nav-icon fas fa-signal  "></i>
                          <p>
                            Burndown Chart
                          </p>
                        </a>
                      </li>

                      <li class="nav-item">
                            <a href="{{ route('dashboard.calendrier',$projectId) }}" class="{{ (request()->is('dashboard/calendrier/'.$projectId)) ? 'nav-link active' : 'nav-link'}}">
                              <i class="nav-icon fas fa-calendar-check"></i>
                              <p>
                                Calendrier
                              </p>
                            </a>
                        </li>
                      
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        @yield('content')
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
 <!-- <aside class="control-sidebar control-sidebar-dark"> -->
    <!-- Control sidebar content goes here 
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside> -->
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src={{ url("bower_components/admin-lte/plugins/jquery/jquery.min.js") }}></script>
<!-- jQuery-UI -->
<script src={{ url("bower_components/admin-lte/plugins/jquery-ui/external/jquery/jquery.js") }}></script>
<!-- Bootstrap 4 -->
<script src={{ url("bower_components/admin-lte/plugins/bootstrap/js/bootstrap.bundle.min.js") }}></script>
<!-- AdminLTE App -->
<script src={{ url("bower_components/admin-lte/dist/js/adminlte.min.js") }}></script>

<script src={{ url("bower_components/admin-lte/dist/js/pages/dashboard.js") }}></script>




<script>



    $("#save-data").click(function(){
        event.preventDefault();
        $('#badge').hide();
        let notification = {!! json_encode(Auth()->user()->notifications()->toArray()) !!};
        let notif = [];

        $('.notif-id').each(function() {
        var currentElement = $(this);
        var value = currentElement.val(); 
        notif.push(value);

        });
          
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });
        
      $.ajax({
        
        url: "http://localhost/gestion-projet/public/ajax-request",
        type:"POST",
        data:{
          notification: notif,
        },
        success:function(response){
          console.log(response);
          if(response) {
            $("#ajaxform")[0].reset();
          }
        },
       });



        });

     
  </script>

@yield('js')
</body>
</html>
