<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Routing\Controller;

class AuthController extends Controller
{
     public function login(Request $request)
    {
        $credentials = $request->only('clave_institucional', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect('/home');
        }

        return back()->with('error','Credenciales incorrectas');
    }


    public function showRegister()
    {
        return view('auth.register');
    }


    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'clave_institucional' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'clave_institucional' => $data['clave_institucional'],
            'password' => Hash::make($data['password']),
            'role' => 'user',
            'is_active' => true,
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect('/home');
    }

 
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }


    public function welcome()
    {
        return view('welcome');
    }

    public function home()
    {
        return view('home');
    }


    public function dashboard()
    {
        return view('dashboard');
    }
}