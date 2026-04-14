<?php

namespace App\Http\Controllers;



use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Models\User;
use Hash;

class AuthController extends Controller

{

    public function index()
    {
        return view('admin.auth.login');
    }

    public function registration()
    {
        return view('admin.auth.registration');
    }

    public function postLogin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->route('admin.dashboard')
                ->withSuccess('You have Successfully loggedin');
        }

        return redirect()->route('login')->with('error', 'Invalid credentials');
    }

    public function postRegistration(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
        $data = $request->all();
        $user = $this->create($data);
        Auth::login($user);
        return redirect()->route('admin.dashboard')->withSuccess('Great! You have Successfully registered and logged in');
    }

    public function dashboard()
    {
        if (Auth::check()) {
            return view('dashboard');
        }
        return redirect("login")->withSuccess('Opps! You do not have access');
    }

    public function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password'])
        ]);
    }

    public function logout()
    {
        Session::flush();
        Auth::logout();
        return Redirect('login');
    }
}
