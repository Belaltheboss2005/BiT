@extends('layouts.master')

@section('title', 'Login')
@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg border-0">
                <div class="card-body bg-light">
                    <h2 class="mb-4 text-center" style="color:#ff5722; font-weight:bold;">Login</h2>
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="email" name="email" required autofocus>
                        </div>
                        <div class="mb-3 d-flex justify-content-between align-items-center">
                            <label for="password" class="form-label">Password</label>
                        </div>
                        <div class="mb-3">
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="mb-3">
                            <a href="{{ route('password.request') }}" class="small" style="color:#007bff;">Forgot Password?</a>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 mb-2">Login</button>
                        <a href="{{ route('login_with_google') }}" class="btn btn-success w-100" style="border:none; font-weight:bold;">
                            <i class="bi bi-google"></i> Login with Google
                        </a>
                        <a href="{{ route('login_with_microsoft') }}" class="btn btn-info w-100 mt-2" style="background:#2F2FEE; border:none; font-weight:bold; color:white;">
                            <i class="bi bi-microsoft"></i> Login with Microsoft
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
