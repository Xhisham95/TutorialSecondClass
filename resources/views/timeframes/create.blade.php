@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h2>Create New Timeframe</h2>

        <form action="{{ route('timeframes.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="Event_Type">Event Type</label>
                <select name="Event_Type" id="Event_Type" class="form-control" required>
                    <option value="">Select an Event Type</option>
                    <option value="Supervisor Post Topics">Supervisor Post Topics</option>
                    <option value="Student Apply for Topics">Student Apply for Topics</option>
                    <option value="Supervisor Accept Applications">Supervisor Accept Applications</option>
                    <option value="Project Proposal Submission">Project Proposal Submission</option>
                    <option value="Proposal Defense">Proposal Defense</option>
                    <option value="Progress Report 1 Submission">Progress Report 1 Submission</option>
                    <option value="Progress Report 2 Submission">Progress Report 2 Submission</option>
                    <option value="Mid-Term Presentation">Mid-Term Presentation</option>
                    <option value="Final Report Submission">Final Report Submission</option>
                    <option value="Final Presentation">Final Presentation</option>
                    <option value="Project Poster Submission">Project Poster Submission</option>
                    <option value="Project Demonstration">Project Demonstration</option>
                    <option value="Peer Review Period">Peer Review Period</option>
                    <option value="Ethics Approval Submission">Ethics Approval Submission</option>
                    <option value="Literature Review Submission">Literature Review Submission</option>
                    <option value="Project Registration">Project Registration</option>
                    <option value="Supervisor Meeting Period">Supervisor Meeting Period</option>
                </select>
            </div>
            <div class="form-group">
                <label for="Start_Date">Start Date</label>
                <input type="date" name="Start_Date" id="Start_Date" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="End_Date">End Date</label>
                <input type="date" name="End_Date" id="End_Date" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="Semester">Semester</label>
                <input type="text" name="Semester" id="Semester" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success mt-3">Save</button>
        </form>
    </div>
@endsection
