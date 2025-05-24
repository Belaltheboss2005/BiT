@extends('layouts.master')
@section('title', 'Roles & Permissions Management')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Roles & Permissions Management</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="row">
        <div class="col-md-6">
            <h3>Add/Edit Role</h3>
            <form method="POST" action="{{ route('spatie.addrole') }}">
                @csrf
                <div class="form-group">
                    <label for="role_name">Role Name</label>
                    <input type="text" name="role_name" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary mt-2">Add Role</button>
            </form>
            <form method="POST" action="{{ route('spatie.editrole') }}" class="mt-3">
                @csrf
                <div class="form-group">
                    <label for="edit_role_id">Select Role</label>
                    <select name="edit_role_id" class="form-control" required>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="edit_role_name">New Role Name</label>
                    <input type="text" name="edit_role_name" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-warning mt-2">Edit Role</button>
            </form>
        </div>
        <div class="col-md-6">
            <h3>Add/Edit Permission</h3>
            <form method="POST" action="{{ route('spatie.addpermission') }}">
                @csrf
                <div class="form-group">
                    <label for="permission_name">Permission Name</label>
                    <input type="text" name="permission_name" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary mt-2">Add Permission</button>
            </form>
            <form method="POST" action="{{ route('spatie.editpermission') }}" class="mt-3">
                @csrf
                <div class="form-group">
                    <label for="edit_permission_id">Select Permission</label>
                    <select name="edit_permission_id" class="form-control" required>
                        @foreach($permissions as $permission)
                            <option value="{{ $permission->id }}">{{ $permission->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="edit_permission_name">New Permission Name</label>
                    <input type="text" name="edit_permission_name" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-warning mt-2">Edit Permission</button>
            </form>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-6">
            <h3>Assign Permission to Role</h3>
            <form method="POST" action="{{ route('spatie.assignpermission') }}">
                @csrf
                <div class="form-group">
                    <label for="role_id">Role</label>
                    <select name="role_id" class="form-control" required>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="permission_id">Permission</label>
                    <select name="permission_id" class="form-control" required>
                        @foreach($permissions as $permission)
                            <option value="{{ $permission->id }}">{{ $permission->name }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-success mt-2">Assign Permission</button>
            </form>
        </div>
        <div class="col-md-6">
            <h3>Assign Role to User</h3>
            <form method="POST" action="{{ route('spatie.assignrole') }}">
                @csrf
                <div class="form-group">
                    <label for="user_id">User</label>
                    <select name="user_id" class="form-control" required>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="role_id">Role</label>
                    <select name="role_id" class="form-control" required>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-success mt-2">Assign Role</button>
            </form>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-6">
            <h3>Delete Role</h3>
            <form method="POST" action="{{ route('spatie.deleterole') }}">
                @csrf
                <div class="form-group">
                    <label for="role_id">Select Role</label>
                    <select name="role_id" class="form-control" required>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-danger mt-2">Delete Role</button>
            </form>
        </div>
        <div class="col-md-6">
            <h3>Delete Permission</h3>
            <form method="POST" action="{{ route('spatie.deletepermission') }}">
                @csrf
                <div class="form-group">
                    <label for="permission_id">Select Permission</label>
                    <select name="permission_id" class="form-control" required>
                        @foreach($permissions as $permission)
                            <option value="{{ $permission->id }}">{{ $permission->name }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-danger mt-2">Delete Permission</button>
            </form>
        </div>
    </div>
</div>
@endsection
