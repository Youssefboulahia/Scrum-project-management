@extends('layouts.admin',['projectId'=>$project->id])

@section('projectName')
    {{$project->name}}
@endsection
    
@section('content')

<div class="container p-0">
            <div class="row justify-content-center">
                <div class="col-sm-9 px-2 py-4">
                        <form action="{{ route('sprint.store',$project->id) }}" method="POST">
                          @csrf
                                <div class="form-row">
                                        <div class="form-group col-md-8">
                                          <label for="nom">Nom du sprint:</label>
                                          <input type="text" class="form-control" id="nom" name="nom" required>
                                        </div>
                                        <div class="form-group col-md-4">
                                          <label for="délai">Délai du sprint:</label>
                                          <select id="délai" class="form-control" name="délai" required>
                                            <option selected>2 semaines</option>
                                            <option>3 semaines</option>
                                            <option>4 semaines</option>
                                          </select>
                                        </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                            <div id="add" class="btn btn-outline-primary" style="width:100%">Ajouter User Story</div>
                                    </div>
                                </div>

                                <table class="table" id="dynamicTable">  
                                        <tr>  
                                                <td>
                                                        <select id="select0" class="form-control" name="select[0]" required>
                                                          <option value="" disabled selected hidden>Choisissez User Story</option>
                                                           @foreach ($userStory as $us)
                                                               @if ($us->phase==='undone')
                                                                <option class="iter">{{ $us->description }}</option>
                                                               @endif
                                                           @endforeach
                                                         </select>
                                                </td>
                                                <td>
                                                         <select id="dev0" class="form-control" name="dev[0]" required>
                                                          <option value="" disabled selected hidden>Affecter un développeur</option>
                                                          @foreach ($developers as $developer)
                                                              <option>{{ $developer->name }}</option>
                                                          @endforeach
                                                        </select>
                                                        
                                                   </td>
                                        </tr> 
                                </table> 

                                    <button type="submit" class="btn btn-primary">sauvegarder</button>
                        </form>
                </div>
            </div>
</div>

@endsection


@section('js')

<script type="text/javascript">
   
    var i = 0;

    var iter = $('.iter').length;


    $("#add").click(function(){

   if(iter>i+1)
   {
   ++i;
   $("#dynamicTable").append('<tr id="tr'+i+'">  <td id="td'+i+'"> </td>    <td id="tdd'+i+'"> </td>    <td id="tdr'+i+'"> </td>   </tr>');
   $("#select0").clone().attr('name','select['+i+']').attr('id','select'+i).appendTo("#td"+i);
   $("#dev0").clone().attr('name','dev['+i+']').attr('id','dev'+i).appendTo("#tdd"+i);
   $("#tdr"+i).append('<button type="button" class="btn btn-danger remove-tr">Remove</button>');
   }
   else{
    window.alert("Il y a seulement "+iter+" User Story disponible");
   }


});




$(document).on('click', '.remove-tr', function(){  
  --i;
    $(this).parents('tr').remove();
}); 


    
   
</script>
    
@endsection