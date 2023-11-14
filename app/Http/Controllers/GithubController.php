<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;



class GithubController extends Controller
{
    public function redirect(){
        return Socialite::driver('github')->redirect();
    }

    public function callback(){

        try{
            $user = Socialite::driver('github')->user();
            //   \ray($user);
            $gitUser = User::updateOrCreate([
                'github_id' => $user->id,
            ], [
                'name' => $user->name,
                'nickname' => $user->nickname,
                'email' => $user->email,
                'github_token' => $user->token,
                'auth_type' => 'github',
                'password' => Hash::make(Str::random(10))
            ]);
            Auth::login($gitUser);
            return redirect('/dashboard');
        }

        catch(\Exception $e){
            // ray($e->getMessage());  
        }

        // $githubUser = Socialite::driver('github')->user();

    }
}
