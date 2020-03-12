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
            $user = Socialite::driver('google')->user();
        } catch(\Exception $e){
            return "Error";
        }
        $existingUser = User::find(['email',$user->email]);

        if($existingUser){
            //auth()->login($existingUser);
            DB::table('users')
                ->where('email',$user->email)
                ->update(['remember_token'=>$user->token]);
            //auth()->login($existingUser);
        } else{
            DB::table('users')
                ->insert(['email'=>$user->email,'remember_token'=>$user->token]);
            $existingUser = User::find($user->email);
            //auth()->login($existingUser);
        }
        
        return redirect()->to('/home');

        //return redirect()->route('home',['user'=>$user]);
        // $user->token;
    }
}