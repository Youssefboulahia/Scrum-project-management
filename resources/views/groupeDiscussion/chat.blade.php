@extends('layouts.admin',['projectId'=>$project->id,'groupeId'=>$groupe->id])

@section('projectName')
    {{$project->name}}
@endsection

@section('css')
    <link rel="stylesheet" href={{asset("css/groupe.css" )}}>
    
@endsection

    
@section('content')



<div class="container">
<div class="wrapper wrapper-content animated fadeInRight">
    
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox chat-view">
                <div class="ibox-title">
                    Groupe de discussion:   {{ $groupe->title }}
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-md-9 " >
                            <div class="chat-discussion"id="chat-discussion" >


                                @foreach($messages as $msg)
                                    @if ($msg->writer_id === Auth()->user()->id)
                                    <div class="chat-message right">
                                            <img class="message-avatar" src="{{ $msg->developer->hasPicture()?asset('storage/'.$msg->developer->getPicture()) : $msg->developer->getCheckedGravatar()   }}" style="width:45px;height:45px" alt="photo">
                                            <div class="message">
                                                <span class="message-author text-primary" > {{ $msg->developer->name }} </span>
                                                <span class="message-date"> {{ $msg->created_at->format('D d M yy - h:m:s') }} </span>
                                                <span class="message-content">
                                                   {{ $msg->message }}
                                                    </span>
                                            </div>
                                        </div>

                                    @else
                                    <div class="chat-message left">
                                            <img class="message-avatar" src="{{ $msg->developer->hasPicture()?asset('storage/'.$msg->developer->getPicture()) : $msg->developer->getCheckedGravatar()   }}" style="width:45px;height:45px" alt="photo">
                                            <div class="message">
                                                <span class="message-author text-primary"> {{ $msg->developer->name }} </span>
                                                <span class="message-date"> {{ $msg->created_at->format('D d M yy - h:m:s') }} </span>
                                                <span class="message-content">
                                                        {{ $msg->message }}
                                                    </span>
                                            </div>
                                        </div>
                                    @endif

                                @endforeach


                                
                                
                                

                            </div>

                        </div>
                        <div class="col-md-3">
                            <div class="chat-users">

                                
                                <div class="users-list">
                                    @foreach ($groupe->groupeDevelopers() as $developer)
                                    <div class="chat-user">
                                            <img class="chat-avatar" src="{{ $developer->developer->hasPicture()?asset('storage/'.$developer->developer->getPicture()) : $developer->developer->getCheckedGravatar()   }}" alt="">
                                            <div class="chat-user-name">
                                                {{ $developer->developer->name }}
                                            </div>
                                        </div>
                                    @endforeach
                                  
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="message_write">
                            <form action="{{ route('message.create',$project->id) }}" method="POST">
                            @csrf
                                    <textarea class="form-control" name="message" placeholder="Écrire un message..."></textarea>
                                    <input type="text" hidden value="{{ $groupe->id }}" name="groupe">
                                    <div class="clearfix"></div>
                                    <div class="row justify-content-end">
                                        <div class="col-auto">
                                                <button type="submit" class="col btn btn-success">Envoyer</button></div>
                                        </div>
                                        
                                    </div>
                            </form>
                            
                    </div>
            </div>
        </div>
    </div>
</div>
</div>


@endsection







@section('js')


<script src="https://use.fontawesome.com/45e03a14ce.js"></script>
      <script>
      $('#chat-discussion').stop ().animate ({
  scrollTop: $('#chat-discussion')[0].scrollHeight
});
      </script>
      
@endsection