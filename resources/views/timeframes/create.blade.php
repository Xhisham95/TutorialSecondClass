@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h2>Create New Timeframe</h2>

        <form action="{{ route('timeframes.store') }}" method="POST">
            @csrf
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
