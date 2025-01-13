@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit User</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('users.update', $user->User_ID) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="UserName">UserName:</label>
            <input type="text" name="UserName" value="{{ $user->UserName }}" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="Email">Email:</label>
            <input type="email" name="Email" value="{{ $user->Email }}" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="Role">Role:</label>
            <select name="Role" class="form-control" required>
                <option value="Student" {{ $user->Role == 'Student' ? 'selected' : '' }}>Student</option>
                <option value="Lecturer" {{ $user->Role == 'Lecturer' ? 'selected' : '' }}>Lecturer</option>
                <option value="FYP_Coordinator" {{ $user->Role == 'FYP_Coordinator' ? 'selected' : '' }}>FYP Coordinator</option>
            </select>
        </div>

        <div class="form-group">
            <label for="Program">Program:</label>
            <input type="text" name="Program" value="{{ $user->Program }}" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary mt-3">Save Changes</button>
    </form>
</div>
@endsection
