<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Slot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AppointmentController extends Controller
{
    // View appointments based on role
    public function manageAppointments()
    {
        $user = Auth::user();

        if ($user->Role === 'supervisor') {
            // Fetch appointments for supervisor
            $appointments = Appointment::with('student', 'slot')
                ->whereHas('slot', function ($query) use ($user) {
                    $query->where('supervisor_id', $user->id);
                })
                ->get();

            return view('supervisors.appointments', compact('appointments'));
        } elseif ($user->Role === 'student') {
            // Fetch appointments for student
            $appointments = Appointment::with('slot')
                ->where('student_id', $user->id)
                ->get();

            return view('students.appointments', compact('appointments'));
        } elseif ($user->Role === 'admin') {
            // Fetch all appointments for admin
            $appointments = Appointment::with(['student', 'slot.supervisor'])->get();

            return view('admin.appointments', compact('appointments'));
        }

        // If role is not recognized, deny access
        return abort(403, 'Unauthorized action.');
    }


    public function addSlot(Request $request)
    {
        $user = Auth::user();

        if ($user->role === 'supervisor') {
            $validated = $request->validate([
                'date' => 'required|date',
                'start_time' => 'required|date_format:H:i',
                'end_time' => 'required|date_format:H:i|after:start_time',
            ]);

            Slot::create([
                'supervisor_id' => $user->id,
                'date' => $validated['date'],
                'start_time' => $validated['start_time'],
                'end_time' => $validated['end_time'],
                'available' => true,
            ]);

            return redirect()->route('appointments.manage')->with('success', 'Slot added successfully.');
        }

        return abort(403, 'Unauthorized action.');
    }

    public function applyForAppointment(Request $request)
    {
        $user = Auth::user();

        if ($user->role === 'student') {
            $validated = $request->validate([
                'slot_id' => 'required|exists:slots,id',
            ]);

            $slot = Slot::find($validated['slot_id']);
            if (!$slot || !$slot->available) {
                return back()->withErrors(['slot' => 'This slot is no longer available.']);
            }

            Appointment::create([
                'student_id' => $user->id,
                'slot_id' => $slot->id,
                'status' => 'Pending',
            ]);

            $slot->update(['available' => false]);

            return redirect()->route('appointments.manage')->with('success', 'Appointment requested successfully.');
        }

        return abort(403, 'Unauthorized action.');
    }

    public function manageAppointmentStatus(Request $request, Appointment $appointment)
    {
        $user = Auth::user();

        if ($user->role === 'supervisor') {
            $validated = $request->validate([
                'status' => 'required|in:Approved,Rejected',
            ]);

            if ($appointment->slot->supervisor_id !== $user->id) {
                return abort(403, 'Unauthorized action.');
            }

            $appointment->update(['status' => $validated['status']]);

            return redirect()->route('appointments.manage')->with('success', 'Appointment status updated successfully.');
        }

        return abort(403, 'Unauthorized action.');
    }

    public function adminView()
    {
        // Get all appointments
        $appointments = Appointment::with(['student', 'supervisor', 'slot'])->get();

        // Pass appointments to the view
        return view('admin.appointments', compact('appointments'));
    }
}
