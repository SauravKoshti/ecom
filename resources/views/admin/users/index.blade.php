@extends('admin.layouts.app')
@section('title','Users')

@section('content')
<div class="page-header">
    <h1 class="page-title">Users</h1>
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-lg"></i> New User
    </a>
</div>
<div class="card">
    <div class="table-responsive">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Created</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td style="color:var(--text-muted)">#{{ $user->id }}</td>
                    <td>
                        <div style="font-weight:600">{{ $user->name }}</div>
                    </td>
                    <td style="color:var(--text-muted)">{{ $user->email }}</td>
                    <td>
                        <span class="badge bg-{{ $user->role === 'admin' ? 'primary' : 'secondary' }}">
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>
                    <td>
                        <span class="badge bg-{{ $user->email_verified_at ? 'success' : 'warning' }}">
                            {{ $user->email_verified_at ? 'Verified' : 'Unverified' }}
                        </span>
                    </td>
                    <td style="color:var(--text-muted);font-size:12px">{{ $user->created_at->format('M d, Y') }}</td>
                    <td class="text-end">
                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-pencil"></i>
                        </a>
                        @if($user->id !== auth()->id())
                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                              class="d-inline" onsubmit="return confirm('Delete this user?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align:center;padding:48px;color:var(--text-muted)">
                        <i class="bi bi-people" style="font-size:32px;display:block;margin-bottom:8px;opacity:.4"></i>
                        No users found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">{{ $users->links() }}</div>
@endsection