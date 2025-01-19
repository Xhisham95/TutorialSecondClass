<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index()
    {
        $mockUserId = 1; // Replace with an existing user ID from your database
        $appointments = Appointment::where('student_id', $mockUserId)->get();

        return view('appointments.index', compact('appointments'));
    }


    public function create(Request $request)
    {
        // Validate the incoming data
        $validated = $request->validate([
            'supervisor_id' => 'required|exists:users,id',
            'appointment_date' => 'required|date|after:now',
            'appointment_time' => 'required',
        ]);

        // Create a new appointment
        Appointment::create([
            'student_id' => auth()->id(),
            'supervisor_id' => $validated['supervisor_id'],
            'appointment_date' => $validated['appointment_date'],
            'appointment_time' => $validated['appointment_time'],
        ]);

        // Redirect with a success message
        return redirect()->route('appointments.index')->with('success', 'Appointment created successfully!');
    }
}
