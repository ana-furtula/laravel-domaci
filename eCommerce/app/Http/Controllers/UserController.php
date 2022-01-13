<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    function login(Request $req)
    {
        $user = User::where(['email' => $req->email])->first();
        if (!$user || !Hash::check($req->password, $user->password)) {
            Session::now('message', 'Username or password not matched.');
            return view('login');
        } else {
            $req->session()->put('user', $user);
            return redirect('/');
        }
    }

    function register(Request $req)
    {
        if ($req->session()->has('user')) {
            Session::now('message', 'You are already logged in.');
            return view('register');
        }
        $validator = Validator::make($req->all(), [
            'username' => 'required|string|max:255',
            'email' => 'required|string|max:255|email',
            'password' => 'required|string|min:2'
        ]);

        if ($validator->fails()) {
            Session::now('message', 'Invalid data input.');
            return view('register');
        }
        $u = User::where(['email' => $req->email])->first();
        if ($u) {
            Session::now('message', 'User with this data already exists.');
            return view('register');
        } else {
            $user = User::create([
                'username' => $req->username,
                'email' => $req->email,
                'password' => Hash::make($req->password)
            ]);
            $user->createToken('auth_token')->plainTextToken;
            Session::now('message', 'Successfull registration. Login required!');
            return view('/login');
        }
    }
}
