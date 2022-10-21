@extends('layouts.app')
@section('content')
    
<div class="container p-5">



    <div class="row  justify-content-center mb-5">
        <div class="col-md-3">
          <img src="{{ Auth()->user()->hasPicture()?asset('storage/'.Auth()->user()->getPicture()) : Auth()->user()->getCheckedGravatar()    }}" alt="Photo de profile"style="border-radius:50%;width:70%;" class="ml-5">
        </div>
        
    </div>
    
    <form action="{{ route('profile.store') }}" enctype="multipart/form-data" method="post">
    
    @csrf
    <div class="row justify-content-center mb-5 mt-n3">
        <div class="col-md-4 offset-md-2">
            <input type="file" name="picture">
        </div>
    </div>
    

    <div class="form-group">
            <label for="name">Nom</label>
            <input value="{{ $user->name }}" type="text" class="form-control" name="name">
    </div>

    <div class="form-group">
            <label for="password">{{ __('Password') }}</label>
    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password" >

        @if(session()->has('warning'))
            <div class="alert alert-warning">
                {{ session()->get('warning') }}
            </div> 
          @endif
                    
                
        </div>

        <div class="form-group">
            <label for="nom">A propos</label>
        <textarea type="text" class="form-control" name="about" placeholder="Tell us about you">{{ $profile->about }}</textarea>
        </div>
        <div class="form-group">
                <label for="telephone">Adresse</label>
                <input value="{{ $profile->adresse }}" type="text" class="form-control" name="adresse">
        </div>
        <div class="form-group">
                <label for="telephone">Telephone</label>
                <input value="{{ $profile->telephone }}" type="number" class="form-control" name="telephone">
        </div>
        

        <button type="submit" class="btn btn-primary">Mettre à jour</button>
    </form>
</div>



@endsection
   

