@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Your Appointments</h1>
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>Supervisor ID</th>
                <th>Date</th>
                <th>Time</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($appointments as $appointment)
            <tr>
                <td>{{ $appointment->supervisor_id }}</td>
                <td>{{ $appointment->appointment_date }}</td>
                <td>{{ $appointment->appointment_time }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <form action="{{ route('appointments.create') }}" method="POST">
        @csrf
        <h2>Create New Appointment</h2>
        <div class="mb-3">
            <label for="supervisor_id" class="form-label">Supervisor ID</label>
            <input type="text" class="form-control" id="supervisor_id" name="supervisor_id" required>
        </div>
        <div class="mb-3">
            <label for="appointment_date" class="form-label">Appointment Date</label>
            <input type="date" class="form-control" id="appointment_date" name="appointment_date" required>
        </div>
        <div class="mb-3">
            <label for="appointment_time" class="form-label">Appointment Time</label>
            <input type="time" class="form-control" id="appointment_time" name="appointment_time" required>
        </div>
        <button type="submit" class="btn btn-primary">Create Appointment</button>
    </form>
</div>
@endsection