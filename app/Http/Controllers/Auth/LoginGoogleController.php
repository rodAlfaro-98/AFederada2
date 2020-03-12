<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use DB; 
use App\User;
use Socialite;

class LoginGoogleController extends Controller
{
    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider()
    {
        //return Socialite::driver('google')->redirect();
        return Scorialite::driver('google')->stateless()->user();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback()
    {
        try{
            $user = Socialite::driver('google')->stateless()->user();
        } catch(\Exception $e){
            return redirect()->to('/');
        }
        $existingUser = User::where('email',$user->email)->first();
        //return (array) $existingUser;

        if($existingUser){
            //return (array) $existingUser;
            DB::table('users')
                ->where('email',$user->email)
                ->update(['remember_token'=>$user->token]);
            auth()->login($existingUser, true);
        } else{
            //return 'Non existing';
            /*DB::table('users')
                ->insert(['first_name'=>$user->given_name,'last_name'=>$user->family_name,'email'=>$user->email,'remember_token'=>$user->token]);
            $existingUser = User::find(['email',$user->email]);
            auth()->login($existingUser, true);*/
            return redirect()->to('/');
        }
        
        return redirect()->to('/home');

        //return redirect()->route('home',['user'=>$user]);
        // $user->token;
    }
}