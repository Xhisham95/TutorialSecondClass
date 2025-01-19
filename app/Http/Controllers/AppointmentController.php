<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    // Show the list of appointments for the authenticated user
    public function index()
    {
        $appointments = Appointment::where('student_id', auth()->id())->get();

        return view('appointments.index', compact('appointments'));
    }

    // Show the form to create an appointment
    public function createForm()
    {
        // Pass a list of supervisors to the view (assuming you have a User model with a supervisor role)
        $supervisors = \App\Models\User::where('role', 'supervisor')->get();

        return view('appointments.create', compact('supervisors'));
    }

    // Create a new appointment
    public function create(Request $request)
    {
        $validated = $request->validate([
            'supervisor_id' => 'required|exists:users,id',
            'appointment_date' => 'required|date|after:now',
            'appointment_time' => 'required',
        ]);

        // Check if the student already has an appointment with the same supervisor in the current week
        $existing = Appointment::where('student_id', auth()->id())
            ->where('supervisor_id', $validated['supervisor_id'])
            ->whereBetween('appointment_date', [now()->startOfWeek(), now()->endOfWeek()])
            ->first();

        if ($existing) {
            return back()->withErrors(['error' => 'You can only book one appointment with this supervisor per week.']);
        }

        Appointment::create([
            'student_id' => auth()->id(),
            'supervisor_id' => $validated['supervisor_id'],
            'appointment_date' => $validated['appointment_date'],
            'appointment_time' => $validated['appointment_time'],
            'status' => 'Pending',
        ]);

        return redirect()->route('appointments.index')->with('success', 'Appointment created successfully!');
    }

    // Cancel an appointment
    public function cancel(Appointment $appointment)
    {
        // Ensure the appointment belongs to the authenticated user and is pending
        if ($appointment->student_id !== auth()->id() || $appointment->status !== 'Pending') {
            return back()->withErrors(['error' => 'You can only cancel your pending appointments.']);
        }

        $appointment->update(['status' => 'Cancelled']);

        return back()->with('success', 'Appointment canceled successfully!');
    }

    // Approve an appointment (Supervisor action)
    public function approve(Appointment $appointment)
    {
        // Ensure the authenticated user is the supervisor for this appointment
        if ($appointment->supervisor_id !== auth()->id() || $appointment->status !== 'Pending') {
            return back()->withErrors(['error' => 'You can only approve pending appointments assigned to you.']);
        }

        $appointment->update(['status' => 'Approved']);

        return back()->with('success', 'Appointment approved successfully!');
    }

    // Reject an appointment (Supervisor action)
    public function reject(Appointment $appointment)
    {
        // Ensure the authenticated user is the supervisor for this appointment
        if ($appointment->supervisor_id !== auth()->id() || $appointment->status !== 'Pending') {
            return back()->withErrors(['error' => 'You can only reject pending appointments assigned to you.']);
        }

        $appointment->update(['status' => 'Rejected']);

        return back()->with('success', 'Appointment rejected successfully!');
    }
}
