<?php
namespace App;

use Laravel\Socialite\Contracts\User as ProviderUser;

class SocialAccountService
{
    public function findOrCreate(ProviderUser $providerUser , $provider)
    {
        //nchoufou ken el compte deja masnou3a bel provider hedheka walé
        $account = SocialAccount::where('provider_id', $providerUser->getId())->where('provider_name',$provider)->first();
        if($account)
        {
            return $account->user;
        }
        else
        {
            //nchoufou ken el email hedhika mosta3mla fi compte walé
            $user = User::where('email',$providerUser->getEmail())->first();
            if(!$user){
                $user = User::create([
                    'email'=>$providerUser->getEmail(),
                    'name'=>$providerUser->getName(),
                ]);
                $profile = new Profile;
                $profile->user_id = $user->id;
                $profile->picture = $providerUser->getAvatar();
                $profile->save();

            }
            $user->accounts()->create([
                'provider_name'=>$provider,
                'provider_id'=>$providerUser->getId(),
                'user_id'=>$user->id,
            ]);
            
            return $user;
        }


    }

}
