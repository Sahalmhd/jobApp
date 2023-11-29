<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function register()
    {
        return view('register');
    }

    public function signup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required',
            'role' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput();
        }

        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');
        $user->role = $request->input('role');
        if ($request->input('role') == 'employee') {
            $user->status = 1;
        }
        $user->password = Hash::make($request->input('password'));
        $user->save();

        // Perform necessary actions with the form data, such as saving to a database

        return redirect('login');
    }
    public function showLoginForm()
    {
        return view('login'); // Assuming you have a 'login.blade.php' view file
    }
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
    
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
    
            // Authentication successful, you can do something with the $user object if needed
    
            return redirect()->intended('register'); // Redirect to the intended page or a default route
        }
    
        // Authentication failed
        return redirect()->route('register')->with('error', 'Invalid credentials');
    }
}    
