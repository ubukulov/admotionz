<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Support\Facades\Redirect;
use App\RoleUser;
class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/authorization';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'login' => 'required|max:50|unique:users',
            'role'  => 'required',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'login' => $data['login'],
            'role'  => $data['role'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
        RoleUser::create([
            'user_id' => $user->id, 'role_id' => $data['role']
        ]);
        return $user;
    }

    protected function auth(){
        $user = User::find(Auth::user()->id);
        foreach ($user->roles as $role){
            if($role->title == 'admin'){
                return Redirect::route('admin');
            }

            if($role->title == 'moderator'){
                return Redirect::route('moderator');
            }

            if($role->title == 'advertiser'){
                return Redirect::route('advertiser');
            }

            if($role->title == 'executer'){
                return Redirect::route('user');
            }

            if($role->title == 'draw'){
                return redirect('drawing');
            }
        }
    }

    public function authenticate(Request $request){
        if(Auth::attempt(['login' => $request->login, 'password' => $request->password, 'block' => 0], $request->remember)){
            return redirect()->intended($this->redirectTo);
        }else{
            dd("Логин или пароль не правильно");
        }
    }
}
