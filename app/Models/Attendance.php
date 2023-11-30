<?php
// app/Models/Attendance.php

// app/Models/Attendance.php

// app/Models/Attendance.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $table = 'attendance';

    protected $fillable = [
        'user_id',
        'attended_at',
        'punch_in',
        'punch_out',
    ];



    // You may define relationships or other methods here
}
