<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;
use App\Models\Attendance;

class AttendanceController extends Controller
{
    public function markAttendance(Request $request)
    {
        $user = Auth::user();
        $currentDate = now()->toDateString();

        $existingAttendance = Attendance::where('user_id', $user->id)
            ->whereDate('attended_at', $currentDate)
            ->first();

        $existingPunchIn = Attendance::where('user_id', $user->id)
            ->whereDate('punch_in', $currentDate)
            ->first();

        $punchOutRecorded = Attendance::where('user_id', $user->id)
            ->whereDate('punch_out', $currentDate)
            ->exists();

        $isPunchIn = $request->input('action') === 'punch-in';

        if ($existingAttendance) {
            if (!$punchOutRecorded && !$isPunchIn) {
                $existingAttendance->update([
                    'punch_out' => now(),
                ]);

                return redirect()->back()->with('success', 'Punch-out time recorded successfully.');
            }

            return redirect()->back()->with('error', 'Attendance already marked for today.');
        }

        if ($existingPunchIn && $isPunchIn) {
            // Set the session variable when a punch-in is marked
            session(['punchInMarked' => true]);
            return redirect()->back()->with('success', 'Punch-in time recorded successfully.');
        }

        $data = [
            'user_id' => $user->id,
            'attended_at' => now(),
            'punch_in' => now(),
        ];

        Attendance::create($data);

        // Remove the session variable when attendance is marked
        session()->forget('punchInMarked');

        $message = $isPunchIn ? 'Punch-in' : 'Attendance';
        return redirect()->back()->with('success', "$message time recorded successfully.");
    }
}
