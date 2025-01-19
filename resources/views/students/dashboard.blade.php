@extends('layouts.app')

@section('title', 'Student Dashboard')

@section('content')
<div class="container mt-4">
    <h1>Welcome, {{ Auth::user()->UserName }}!</h1>
    <p>This is your dashboard.</p>


</div>
@endsection
