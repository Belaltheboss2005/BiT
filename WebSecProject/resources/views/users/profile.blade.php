@extends('layouts.master')
@section('title', 'User Profile')
@section('content')
@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif
<div class="row">
    <div class="m-4 col-sm-6">
        <table class="table table-striped">
            <tr>
                <th>Name</th><td>{{$user->name}}</td>
            </tr>
            <tr>
                <th>Email</th><td>{{$user->email}}</td>
            </tr>
            <tr>
                <th>Credit</th><td>{{$user->credit}}</td>
            </tr>
            <tr>
                <th>Roles</th>
                <td>
                    @foreach($user->roles as $role)
                        <span class="badge bg-primary">{{$role->name}}</span>
                    @endforeach
                </td>
            </tr>
            <tr>
                <th>Permissions</th>
                <td>
                    @foreach($permissions as $permission)
                        <span class="badge bg-success">{{$permission->name}}</span>
                    @endforeach
                </td>
            </tr>
        </table>
        <div class="row">
            @if(!$user->email_verified_at)
                <div class="col col-6 mb-2">
                    <form method="POST" action="{{ route('resend.verification') }}">
                        @csrf
                        <button type="submit" class="btn btn-warning w-100">Send Verification Email</button>
                    </form>
                </div>
            @endif
            <div class="col col-6 mb-2">
                <a class="btn btn-primary w-100" href="{{ route('password.change') }}">Change Password</a>
            </div>
        </div>
    </div>
</div>
@endsection
