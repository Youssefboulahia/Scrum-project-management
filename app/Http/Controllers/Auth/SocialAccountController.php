<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Socialite;
use App\SocialAccountService;
use Illuminate\Support\Facades\Auth;
use View;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class SocialAccountController extends Controller
{
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback(SocialAccountService $profileService ,$provider)
    {
        
            $user = Socialite::driver($provider)->stateless()->user();
     
           
        $authUser = $profileService->findOrCreate($user , $provider);

        if(empty($authUser->password))
        {
            $view = View::make('register.social');
            $view->user = $authUser;
            return $view ;  
        }
        else
        {
            Auth::login($authUser,true);
            return redirect()->to('home');
        }
                
    }

    public function registerSocial(Request $request , $id)
    {
        $user = User::find($id);
        $user->password = Hash::make($request->input('password'));
        $user->picture = 
        $user->save();

        Auth::login($user);
            return redirect()->to('home');
    }
}
