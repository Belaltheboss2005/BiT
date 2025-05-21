@extends('layouts.master')
@section('title', 'Users List')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Users List</h1>

    @if (auth()->user()->hasRole('Admin'))
        <div class="mb-3">
            <a href="{{ route('users.manage', ['action' => 'add']) }}" class="btn btn-primary">Add New User</a>
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if ($action === 'add')
        @can('add-users')
            <h2>Add New User</h2>
            <form method="POST" action="{{ route('users.store') }}">
                @csrf
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="password_confirmation">Confirm Password:</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Create</button>
            </form>
        @endcan
    @endif

    @if ($action === 'edit' && isset($userToEdit))
        @can('edit-users')
            <h2>Edit User</h2>
            <form method="POST" action="{{ route('users.update') }}">
                @csrf
                <input type="hidden" name="user_id" value="{{ $userToEdit->id }}">
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $userToEdit->name) }}" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $userToEdit->email) }}" required>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        @endcan
    @endif

    <!-- Search Form -->
    <form method="GET" action="{{ route('users.manage') }}" class="mb-4">
        <div class="row">
            <div class="col-md-4">
                <input type="text" name="keywords" class="form-control" placeholder="Search Keywords" value="{{ request('keywords') }}">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            <div class="col-md-2">
                <a href="{{ route('users.manage') }}" class="btn btn-danger">Reset</a>
            </div>
        </div>
    </form>

    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">All Users</h4>
        </div>
        <div class="card-body">
            @if (count($users) > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Roles</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @foreach ($user->roles as $role)
                                            <span class="badge bg-primary">{{ $role->name }}</span>
                                        @endforeach
                                    </td>
                                    <td>
                                        @if ($user->is_blocked ?? false)
                                            <span class="badge bg-danger">Blocked</span>
                                        @else
                                            <span class="badge bg-success">Active</span>
                                        @endif
                                    </td>
                                    <td>
                                        @can('edit-users')
                                            <a href="{{ route('users.manage', ['action' => 'edit', 'user_id' => $user->id]) }}" class="btn btn-primary btn-sm">Edit</a>
                                        @endcan
                                        @can('delete-users')
                                            <form action="{{ route('users.destroy', ['user' => $user->id]) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                                            </form>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-warning text-center">
                    No users found.
                </div>
            @endif
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $users->links() }}
    </div>
</div>
@endsection