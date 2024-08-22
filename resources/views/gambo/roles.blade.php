@extends('layouts.main')

@section('content')
<div class="container">
    <h1>Manage User Roles</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>User</th>
                <th>Roles</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>
                        @foreach($user->roles as $role)
                            <span class="badge bg-primary">{{ $role->name }}</span>
                        @endforeach
                    </td>
                    <td>
                        <!-- Form to add role -->
                        <form action="{{ route('roles.add') }}" method="POST" style="display:inline;">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ $user->id }}">
                            <select name="role" required>
                                <option value="">Select Role</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="btn btn-success">Add Role</button>
                        </form>

                        <!-- Form to remove role -->
                        <form action="{{ route('roles.remove') }}" method="POST" style="display:inline;">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ $user->id }}">
                            <select name="role" required>
                                <option value="">Select Role</option>
                                @foreach($user->roles as $role)
                                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="btn btn-danger">Remove Role</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
