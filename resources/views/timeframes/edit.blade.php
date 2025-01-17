@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h2>Edit Timeframe</h2>

        <form action="{{ route('timeframes.update', $timeframe->id) }}" method="POST">
            @csrf
            @method('PUT')
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
