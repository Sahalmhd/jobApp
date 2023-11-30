<?php
// database/migrations/YYYY_MM_DD_create_attendance_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendanceTable extends Migration
{
    // database/migrations/your_migration_file.php

// database/migrations/your_migration_file.php

public function up()
{
    Schema::create('attendance', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('user_id');
        $table->timestamp('attended_at')->nullable();
        $table->timestamp('punch_in')->nullable();
        $table->timestamp('punch_out')->nullable();
        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        $table->timestamps();
    });
}


}