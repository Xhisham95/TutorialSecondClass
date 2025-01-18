@extends('layouts.app')

@section('content')
<h2>Your Appointments</h2>
<a href="{{ route('appointments.create') }}">Create Appointment</a>
<table>
    <tr>
        <th>Date</th>
        <th>Time</th>
        <th>Status</th>
        <th>Actions</th>
    </tr>
    @foreach ($appointments as $appointment)
    <tr>
        <td>{{ $appointment->appointment_date }}</td>
        <td>{{ $appointment->appointment_time }}</td>
        <td>{{ $appointment->status }}</td>
        <td>
            @if ($appointment->status === 'Pending')
            <form action="{{ route('appointments.cancel', $appointment) }}" method="POST">
                @csrf
                <button type="submit">Cancel</button>
            </form>
            @endif
        </td>
    </tr>
    @endforeach
</table>
@endsection