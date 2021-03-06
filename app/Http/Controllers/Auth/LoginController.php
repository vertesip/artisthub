<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Music;
use App\Models\Post;
use App\Models\Profile;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    //Google login
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }
    //Google callback
    public function handleGoogleCallback()
    {
        $user = Socialite::driver('google')->user();

        $this->_registerOrLoginUser($user);


        $users = auth()->user()->following()->pluck('profiles.user_id');
        $posts = Post::whereIn('user_id',$users)->latest()->get();
        $musics = Music::whereIn('user_id',$users)->latest()->get();
        $all_user = User::where('id', '!=', Auth::id())->get();

        return view('home', [
            'posts' => $posts,
            'musics' => $musics,
            'all_user' => $all_user,
        ]);
    }

    //Facebook login
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }
    //Facebook callback
    public function handleFacebookCallback()
    {
        $user = Socialite::driver('facebook')->user();

        $this->_registerOrLoginUser($user);

        $users = auth()->user()->following()->pluck('profiles.user_id');
        $posts = Post::whereIn('user_id',$users)->latest()->get();
        $musics = Music::whereIn('user_id',$users)->latest()->get();
        $all_user = User::where('id', '!=', Auth::id())->get();

        return view('home', [
            'posts' => $posts,
            'musics' => $musics,
            'all_user' => $all_user,
        ]);

    }

    public function _registerOrLoginUser($data)
    {
        $user = User::where('email', '=',$data->email)->first();
        if(!$user){

            $user = new User();
            $user->name = $data->name;
            $user->email = $data->email;
            $user->provider_id = $data->id;
            $user->save();

        }
        Auth::login($user);
    }

}
