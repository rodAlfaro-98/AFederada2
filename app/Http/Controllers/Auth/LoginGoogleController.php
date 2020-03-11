<?php

namespace App\Http\Controllers\Auth;

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
        $user = Socialite::driver('google')->user();

        auth()->login($user);

        return redirect()->to('/home');

        //return redirect()->route('home',['user'=>$user]);
        // $user->token;
    }
}