<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Attendance;


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
    
            return redirect()->route('dash')->with('name', $user->name);        }
    
        // Authentication failed
        return redirect()->route('login')->with('error', 'Invalid credentials');
    }
    public function showDash()
    {
        $user = Auth::user();
        $attendanceStatus = $this->checkAttendanceStatus($user);  // Pass $user to the method

        $name = $user->name;  // Extract the name

        if ($user->role === 'employee') {
            return view('employee-dash', compact('name', 'attendanceStatus'));
        } elseif ($user->role === 'employer') {
            return view('employer-dash', compact('name', 'attendanceStatus'));
        }

        // Handle other roles or situations as needed
    }

    private function checkAttendanceStatus(User $user)
    {
        $currentDate = now()->toDateString();

        // Check if the user has marked attendance today
        $existingAttendance = Attendance::where('user_id', $user->id)
            ->whereDate('attended_at', $currentDate)
            ->first();

        // Check if punch-in has been recorded for today
        $existingPunchIn = Attendance::where('user_id', $user->id)
            ->whereDate('punch_in', $currentDate)
            ->exists();

        // Check if punch-out has been recorded for today
        $punchOutRecorded = Attendance::where('user_id', $user->id)
            ->whereDate('punch_out', $currentDate)
            ->exists();

        if ($existingAttendance) {
            return 'Attendance Marked';
        } elseif ($existingPunchIn && !$punchOutRecorded) {
            return 'Punch In Recorded';
        } else {
            return 'Not Marked';
        }
    }

    // Other methods in your controller...
}