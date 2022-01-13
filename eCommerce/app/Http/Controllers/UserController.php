<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    function login(Request $req)
    {
        $user = User::where(['email' => $req->email])->first();
        if (!$user || !Hash::check($req->password, $user->password)) {
            return "Username or password is not matched.";
        } else {
            $req->session()->put('user', $user);
            return redirect('/');
        }
    }

    function register(Request $req)
    {
        if ($req->session()->has('user')) {
            return view('register', ['info' => "You are already logged in."]);
        }
        $validator = Validator::make($req->all(), [
            'username' => 'required|string|max:255',
            'email' => 'required|string|max:255|email|unique:users',
            'password' => 'required|string|min:2'
        ]);

        if ($validator->fails()) {
            return view('register', ['info' => "Invalid data input."]);
        }
        $u = User::where(['email' => $req->email])->first();
        if ($u) {
            return view('register', ['info' => "User with this data already exists."]);
        } else {
            $user = User::create([
                'username' => $req->username,
                'email' => $req->email,
                'password' => Hash::make($req->password)
            ]);
            $user->createToken('auth_token')->plainTextToken;
            return redirect('/login');
        }
    }
}

    // function register(Request $req)
    // {
    //     $validator = Validator::make($req->all(), [
    //         'username' => 'required|string|max:255',
    //         'email' => 'required|string|max:255|email|unique:users',
    //         'password' => 'required|string|min:2'
    //     ]);

    //     if ($validator->fails()) {
    //         return "User cannot be registrated.";
    //     }
    //     $user = User::create([
    //         'username' => $req->username,
    //         'email' => $req->email,
    //         'password' => Hash::make($req->password)
    //     ]);

    //     $u = User::where(['email' => $req->email])->first();
    //     if ($u) {
    //         return "User already exists.";
    //     } else {
    //         $user->createToken('auth_token')->plainTextToken;
    //         return redirect('/login');
    //     }
    // }
