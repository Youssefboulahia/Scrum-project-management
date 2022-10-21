@extends('layouts.app')
@section('content')
<div class="container">
<form action="{{route('project.store')}}" method="post">
        @csrf

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
            <input type="text" class="form-control" name="description" placeholder="Description projet">
          </div>
        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
</div>

@endsection