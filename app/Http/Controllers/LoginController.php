<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{




    public function redirect()
    {
       return Socialite::driver('github')->redirect();
    }


    public function handleProviderCallback()
 {


    $user = Socialite::driver('github')->user();
    $email = $user->email;
    $user_in_db = user::where('email' , $email)->first();


    if ($user_in_db == null) { // اذا كان المستخدم ليس موجود في الداتا بيز

        $user_create = user::create([ 
            'name' => $user->name,
            'email' => $user->email,
            'password' => $user->name,
            'oauth_token' => $user->token,
            'password' => hash::make('123456789'),

        ]);
        Auth::login($user_create);
        return redirect()->route('dashboard');
    }

    Auth::login($user_in_db); //  اذا كان موجود سابقا

    return redirect()->route('dashboard');

}


}
