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
<h1>Users Report</h1>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $user)
            <tr>
                <td>{{ $user->User_ID }}</td>
                <td>{{ $user->UserName }}</td>
                <td>{{ $user->Email }}</td>
                <td>{{ $user->Role }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
