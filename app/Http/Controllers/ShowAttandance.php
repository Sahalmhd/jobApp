<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;

class ShowAttendanceController extends Controller
{
    public function showAttendance()
    {
        // Assuming there's a relationship between Attendance and User model
        $attendances = Attendance::with('user')
            ->whereNotNull('punch_in')
            ->get();
    
        // You can now access user name and punch-in data in your view or process as needed
        return view('attendance.show', compact('attendances'));
    }
}