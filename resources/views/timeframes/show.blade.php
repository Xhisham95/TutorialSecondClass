@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h2>Timeframe Details</h2>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Semester: {{ $timeframe->Semester }}</h5>
                <p class="card-text">Start Date: {{ $timeframe->Start_Date }}</p>
                <p class="card-text">End Date: {{ $timeframe->End_Date }}</p>
            </div>
        </div>

        <a href="{{ route('timeframes.index') }}" class="btn btn-primary mt-3">Back to Timeframes</a>
    </div>
@endsection


