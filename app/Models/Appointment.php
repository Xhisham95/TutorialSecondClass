<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $table = 'appointments'; // Database table
    protected $primaryKey = 'Appointment_ID'; // Primary key
    protected $fillable = [
        'Student_ID',
        'Supervisor_ID',
        'Appointment_Date',
        'Appointment_Time',
        'Status'
    ]; // Fillable attributes

    // Relationship with User (Student)
    public function student()
    {
        return $this->belongsTo(User::class, 'Student_ID', 'User_ID');
    }

    // Relationship with User (Supervisor)
    public function supervisor()
    {
        return $this->belongsTo(User::class, 'Supervisor_ID', 'User_ID');
    }
}
