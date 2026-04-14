@extends('admin.layouts.app')
@section('title', 'Edit User')

@section('content')
<div class="page-header">
    <h1 class="page-title">Edit User</h1>
    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left"></i> Back to Users
    </a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('admin.users.update', $user) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                               id="name" name="name" value="{{ old('name', $user->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                               id="email" name="email" value="{{ old('email', $user->email) }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="role" class="form-label">Role</label>
                        <select class="form-select @error('role') is-invalid @enderror"
                                id="role" name="role" required>
                            <option value="">Select Role</option>
                            <option value="user" {{ old('role', $user->role) === 'user' ? 'selected' : '' }}>User</option>
                            <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                        @error('role')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password <small class="text-muted">(leave blank to keep current)</small></label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                               id="password" name="password">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control"
                               id="password_confirmation" name="password_confirmation">
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg"></i> Update User
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">User Information</div>
            <div class="card-body">
                <p><strong>ID:</strong> #{{ $user->id }}</p>
                <p><strong>Created:</strong> {{ $user->created_at->format('M d, Y H:i') }}</p>
                <p><strong>Last Updated:</strong> {{ $user->updated_at->format('M d, Y H:i') }}</p>
                <p><strong>Email Verified:</strong>
                    <span class="badge bg-{{ $user->email_verified_at ? 'success' : 'warning' }}">
                        {{ $user->email_verified_at ? 'Yes' : 'No' }}
                    </span>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection