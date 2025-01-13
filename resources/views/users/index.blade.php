@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Manage Users</h1>

    <a href="{{ route('users.create') }}" class="btn btn-primary mb-3">Upload Users (CSV)</a>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>UserName</th>
                <th>Email</th>
                <th>Role</th>
                <th>Program</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
            <tr>
                <td>{{ $user->User_ID }}</td>
                <td>{{ $user->UserName }}</td>
                <td>{{ $user->Email }}</td>
                <td>{{ $user->Role }}</td>
                <td>{{ $user->Program }}</td>
                <td>
                    <a href="{{ route('users.edit', $user->User_ID) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('users.destroy', $user->User_ID) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
