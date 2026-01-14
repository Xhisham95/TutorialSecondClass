@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h2>Edit Timeframe</h2>

        <form action="{{ route('timeframes.update', $timeframe->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
    <label for="Event_Type">Event Type</label>
    <select name="Event_Type" id="Event_Type" class="form-control" required>
        <option value="Supervisor Post Topics" {{ $timeframe->Event_Type === 'Supervisor Post Topics' ? 'selected' : '' }}>Supervisor Post Topics</option>
        <option value="Student Apply for Topics" {{ $timeframe->Event_Type === 'Student Apply for Topics' ? 'selected' : '' }}>Student Apply for Topics</option>
        <option value="Supervisor Accept Applications" {{ $timeframe->Event_Type === 'Supervisor Accept Applications' ? 'selected' : '' }}>Supervisor Accept Applications</option>
        <option value="Project Proposal Submission" {{ $timeframe->Event_Type === 'Project Proposal Submission' ? 'selected' : '' }}>Project Proposal Submission</option>
        <option value="Proposal Defense" {{ $timeframe->Event_Type === 'Proposal Defense' ? 'selected' : '' }}>Proposal Defense</option>
        <option value="Progress Report 1 Submission" {{ $timeframe->Event_Type === 'Progress Report 1 Submission' ? 'selected' : '' }}>Progress Report 1 Submission</option>
        <option value="Progress Report 2 Submission" {{ $timeframe->Event_Type === 'Progress Report 2 Submission' ? 'selected' : '' }}>Progress Report 2 Submission</option>
        <option value="Mid-Term Presentation" {{ $timeframe->Event_Type === 'Mid-Term Presentation' ? 'selected' : '' }}>Mid-Term Presentation</option>
        <option value="Final Report Submission" {{ $timeframe->Event_Type === 'Final Report Submission' ? 'selected' : '' }}>Final Report Submission</option>
        <option value="Final Presentation" {{ $timeframe->Event_Type === 'Final Presentation' ? 'selected' : '' }}>Final Presentation</option>
        <option value="Project Poster Submission" {{ $timeframe->Event_Type === 'Project Poster Submission' ? 'selected' : '' }}>Project Poster Submission</option>
        <option value="Project Demonstration" {{ $timeframe->Event_Type === 'Project Demonstration' ? 'selected' : '' }}>Project Demonstration</option>
        <option value="Peer Review Period" {{ $timeframe->Event_Type === 'Peer Review Period' ? 'selected' : '' }}>Peer Review Period</option>
        <option value="Ethics Approval Submission" {{ $timeframe->Event_Type === 'Ethics Approval Submission' ? 'selected' : '' }}>Ethics Approval Submission</option>
        <option value="Literature Review Submission" {{ $timeframe->Event_Type === 'Literature Review Submission' ? 'selected' : '' }}>Literature Review Submission</option>
        <option value="Project Registration" {{ $timeframe->Event_Type === 'Project Registration' ? 'selected' : '' }}>Project Registration</option>
        <option value="Supervisor Meeting Period" {{ $timeframe->Event_Type === 'Supervisor Meeting Period' ? 'selected' : '' }}>Supervisor Meeting Period</option>
    </select>
</div>


            <div class="form-group">
                <label for="Start_Date">Start Date</label>
                <input type="date" name="Start_Date" id="Start_Date" class="form-control" value="{{ $timeframe->Start_Date }}" required>
            </div>
            <div class="form-group">
                <label for="End_Date">End Date</label>
                <input type="date" name="End_Date" id="End_Date" class="form-control" value="{{ $timeframe->End_Date }}" required>
            </div>
            <div class="form-group">
                <label for="Semester">Semester</label>
                <input type="text" name="Semester" id="Semester" class="form-control" value="{{ $timeframe->Semester }}" required>
            </div>

            <button type="submit" class="btn btn-success mt-3">Update</button>
        </form>
    </div>
@endsection
