@extends('admin.layouts.guest')
@section('title', 'Login')

@section('auth-title', 'Sign in to your account')

@section('content')
<form method="POST" action="{{ route('admin.login.post') }}">
    @csrf
    <div class="mb-3">
        <label for="email" class="form-label">Email address</label>
        <input id="email" name="email" type="email" class="form-control" autocomplete="email" required placeholder="Email address" value="{{ old('email') }}">
        @error('email')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input id="password" name="password" type="password" class="form-control" autocomplete="current-password" required placeholder="Password">
        @error('password')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="form-check">
            <input id="remember" name="remember" type="checkbox" class="form-check-input">
            <label for="remember" class="form-check-label">Remember me</label>
        </div>
        <a href="#" class="text-decoration-none">Forgot password?</a>
    </div>

    <button type="submit" class="btn btn-primary w-100">
        Sign in
    </button>

    <div class="text-center mt-3">
        <p class="mb-0">Don't have an account? <a href="{{ route('admin.registration') }}" class="text-decoration-none">Sign up</a></p>
    </div>
</form>
@endsection 