@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Generate User Report</h1>

    <form action="{{ route('users.report') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-primary">Download Report</button>
    </form>
</div>
@endsection
