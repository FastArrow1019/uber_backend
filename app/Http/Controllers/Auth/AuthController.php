<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Requests;
use Illuminate\Http\Request;
use Validator;
use DB;
use Cookie;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Support\Facades\Auth;
use Hash;
use Session;

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
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
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
            'name' => 'required|max:255',
            // 'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    public function auth(Request $request){

        $this->validate($request, [
            'name' => 'required|max:255|min:5',
            'password' => 'required|min:5',
        ]);
        echo "string";
        return;
        $credentials = $request->only('name', 'password');
        // $results = DB::select('select * from users where user_name = ?', $credentials['user_name']);
        // $test  = DB::table('products')->select();
        if (Auth::attempt($credentials)) {
            return redirect()->intended('welcome');
        }
        return redirect('/');
    }

    public function show(Request $request){
        var_dump("sfdfsff");exit;
        return view('register');
    }

    public function register(Request $request){

    }
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }


    public function signup(Request $request){
        return view('auth.signinup');
    }

    public function signupcontrol(Request $request){
        
        $this->validate($request, [
            'fullname' => 'required|max:255|min:4',
            'password' => 'required|confirmed|min:6',
        ]);
        $username = $request->get("fullname");
        // $email = $request->get("email");
        $pass = $request->get("password");
        session()->flush();
        $pass = bcrypt($pass);
        $dbresult = DB::insert('insert into users (name, password) values (?, ?)', [$username, $pass]);
        if ($dbresult == 1) {
            return redirect('/dashboard');
        }
        else {
            return redirect('/signup');
        }
    }

  public function signin(Request $request){
    return view('auth.signin');
  } 
    public function signincontrol(Request $request){
        $this->validate($request, [
            'name' => 'required|max:255|min:4',
            'password' => 'required|min:6',
        ]);
        $credentials = $request->only('name', 'password');
        if (Auth::attempt($credentials)) {
            $username = $request->get("name");
            $pass = $request->get("password");
            $results = DB::select('select * from users where name = ? and status <> 0', [$username]);
            if (count($results) > 0) {
                foreach($results as $value){
                    if (Hash::check($pass, $value->password)) {
                        Session::put('userid', $value->id);
                        Session::put('status', $value->status);
                        return redirect('/maindash');
                    }
                }
                return redirect('/signin');
                
            }
            else {
                return redirect('/signin');
            }
        }
        return redirect('/signin');
    }      
    
}
