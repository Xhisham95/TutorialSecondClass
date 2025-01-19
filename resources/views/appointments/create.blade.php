@extends('layouts.app')

@section('content')
<h2>Create Appointment</h2>
<form action="{{ route('appointments.create') }}" method="POST">
    @csrf
    <label for="supervisor_id">Supervisor:</label>
    <select name="supervisor_id" required>
        <!-- Populate with actual supervisors -->
    </select>

    <label for="appointment_date">Date:</label>
    <input type="date" name="appointment_date" required>

    <label for="appointment_time">Time:</label>
    <input type="time" name="appointment_time" required>

    <button type="submit">Submit</button>
</form>
@endsection