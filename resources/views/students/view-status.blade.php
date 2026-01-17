@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>My Application Status</h2>
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Topic Title</th>
                <th>Topic Description</th>
                <th>Status</th>
                <th>Remarks</th>
                <th>Applied Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($applications as $application)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $application->Topic_Title }}</td>
                    <td>{{ $application->Topic_Description }}</td>
                    <td>
                        @if($application->application_status === 'Pending')
                            <span class="badge bg-warning">Pending</span>
                        @elseif($application->application_status === 'Accepted')
                            <span class="badge bg-success">Accepted</span>
                        @else
                            <span class="badge bg-danger">Rejected</span>
                        @endif
                    </td>
                    <td>{{ $application->remarks ?? 'N/A' }}</td>
                    <td>{{ \Carbon\Carbon::parse($application->created_at)->format('M d, Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No applications found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
