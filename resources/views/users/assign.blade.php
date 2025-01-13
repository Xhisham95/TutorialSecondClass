@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Assign Lecturers</h1>

    <form action="{{ route('users.assign') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="Student_ID" class="form-label">Select Student</label>
            <select name="Student_ID" id="Student_ID" class="form-control" required>
                @foreach ($students as $student)
                    <option value="{{ $student->User_ID }}">{{ $student->UserName }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="Supervisor_ID" class="form-label">Select Lecturer</label>
            <select name="Supervisor_ID" id="Supervisor_ID" class="form-control" required>
                @foreach ($lecturers as $lecturer)
                    <option value="{{ $lecturer->User_ID }}">{{ $lecturer->UserName }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Assign</button>
    </form>
</div>
@endsection
