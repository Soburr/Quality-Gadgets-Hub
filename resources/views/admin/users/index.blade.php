@extends('admin.layout')

@section('title', 'Users — Admin')

@section('content')
    <div class="admin-header">
        <h1>Users</h1>
        <a href="{{ route('admin.users.export') }}" class="btn btn-primary">Download CSV</a>
    </div>

    <form method="GET" class="admin-search-form">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Search by name or email...">
        <button type="submit">Search</button>
    </form>

    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Joined</th>
                    <th>Role</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->created_at->format('d M Y') }}</td>
                        <td>
                            <span class="admin-badge @if($user->is_admin) admin-badge--delivered @endif">
                                {{ $user->is_admin ? 'Admin' : 'Customer' }}
                            </span>
                        </td>
                        <td class="admin-table-actions">
                            @if($user->id === auth()->id())
                                <span class="admin-hint" style="margin:0;">You</span>
                            @else
                                <form action="{{ route('admin.users.toggleAdmin', $user) }}" method="POST" onsubmit="return confirm('{{ $user->is_admin ? 'Remove admin access from' : 'Make' }} {{ $user->name }} {{ $user->is_admin ? '' : 'an admin' }}?');">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit">{{ $user->is_admin ? 'Remove Admin' : 'Make Admin' }}</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="admin-empty">No users found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($users->hasPages())
        <div class="pager">
            @if($users->previousPageUrl())
                <a href="{{ $users->previousPageUrl() }}" class="pager-btn">&larr; Prev</a>
            @endif
            <span class="pager-info">Page {{ $users->currentPage() }} of {{ $users->lastPage() }}</span>
            @if($users->nextPageUrl())
                <a href="{{ $users->nextPageUrl() }}" class="pager-btn">Next &rarr;</a>
            @endif
        </div>
    @endif
@endsection