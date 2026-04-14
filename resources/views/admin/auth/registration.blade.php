@extends('admin.layouts.guest')
@section('title', 'Registration')

@section('auth-title', 'Create your account')

@section('content')
<form method="POST" action="{{ route('admin.registration.post') }}">
    @csrf
    <div class="mb-3">
        <label for="name" class="form-label">Full Name</label>
        <input id="name" name="name" type="text" class="form-control" autocomplete="name" required placeholder="Full Name" value="{{ old('name') }}">
        @error('name')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email address</label>
        <input id="email" name="email" type="email" class="form-control" autocomplete="email" required placeholder="Email address" value="{{ old('email') }}">
        @error('email')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input id="password" name="password" type="password" class="form-control" autocomplete="new-password" required placeholder="Password">
        @error('password')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>
    <div class="mb-3">
        <label for="password_confirmation" class="form-label">Confirm Password</label>
        <input id="password_confirmation" name="password_confirmation" type="password" class="form-control" autocomplete="new-password" required placeholder="Confirm Password">
        @error('password_confirmation')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary w-100">
        Sign up
    </button>

    <div class="text-center mt-3">
        <p class="mb-0">Already have an account? <a href="{{ route('login') }}" class="text-decoration-none">Sign in</a></p>
    </div>
</form>
@endsection