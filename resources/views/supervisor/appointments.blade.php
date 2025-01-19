@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Manage Appointments</h1>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Student Name</th>
                <th>Date</th>
                <th>Time</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($appointments as $appointment)
            <tr>
                <td>{{ $appointment->student->name }}</td>
                <td>{{ $appointment->slot->date }}</td>
                <td>{{ $appointment->slot->time }}</td>
                <td>{{ $appointment->status }}</td>
                <td>
                    <a href="#" onclick="openManageModal({{ $appointment->id }})" class="btn btn-primary">Manage</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Add modal for managing appointment -->
<script>
    function openManageModal(appointmentId) {
        // Open modal logic here (e.g., fetch details, show approve/reject options)
        alert('Managing Appointment ID: ' + appointmentId);
    }
</script>
@endsection