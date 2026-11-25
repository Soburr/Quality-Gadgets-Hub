@extends('admin.layout')

@section('title', 'Subscribers — Admin')

@section('content')
    <div class="admin-header">
        <h1>Subscribers</h1>
        <a href="{{ route('admin.campaigns.create') }}" class="btn btn-primary">+ New Campaign</a>
    </div>

    @if($errors->any())
        <div class="auth-error">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <div class="campaign-stats" style="max-width:420px;grid-template-columns:repeat(2,1fr);">
        <div class="campaign-stat"><span>Active</span><strong>{{ number_format($stats['active']) }}</strong></div>
        <div class="campaign-stat"><span>Unsubscribed</span><strong>{{ number_format($stats['unsubscribed']) }}</strong></div>
    </div>

    <div class="admin-panel" style="margin-bottom:24px;">
        <h3>Import emails</h3>
        <form action="{{ route('admin.subscribers.import') }}" method="POST" enctype="multipart/form-data" class="admin-form">
            @csrf
            <div class="admin-field">
                <label for="emails">Paste your list</label>
                <textarea id="emails" name="emails" rows="6" placeholder="ada@example.com&#10;tunde@example.com, Tunde&#10;Ngozi, ngozi@example.com">{{ old('emails') }}</textarea>
            </div>
            <div class="admin-field">
                <label for="file">...or upload a CSV / TXT file</label>
                <input type="file" id="file" name="file" accept=".csv,.txt">
            </div>
            <p class="admin-hint" style="margin-bottom:14px;">
                One per line, as "email" or "email, name". Pasting straight from Excel or Google Sheets works. Duplicates are ignored, and anyone who has unsubscribed is never added back.
            </p>
            <button type="submit" class="btn btn-primary">Import</button>
        </form>
    </div>

    <form method="GET" class="admin-search-form">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Search by email or name...">
        <button type="submit">Search</button>
    </form>

    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Email</th>
                    <th>Name</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($subscribers as $subscriber)
                    <tr>
                        <td>{{ $subscriber->email }}</td>
                        <td>{{ $subscriber->name ?: '—' }}</td>
                        <td>
                            <span class="admin-badge @if(!$subscriber->unsubscribed_at) admin-badge--delivered @else admin-badge--cancelled @endif">
                                {{ $subscriber->unsubscribed_at ? 'Unsubscribed' : 'Active' }}
                            </span>
                        </td>
                        <td class="admin-table-actions">
                            <form action="{{ route('admin.subscribers.destroy', $subscriber) }}" method="POST" onsubmit="return confirm('Remove this subscriber?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit">Remove</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="admin-empty">No subscribers yet. Import your list above.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($subscribers->hasPages())
        <div class="pager">
            @if($subscribers->previousPageUrl())
                <a href="{{ $subscribers->previousPageUrl() }}" class="pager-btn">&larr; Prev</a>
            @endif
            <span class="pager-info">Page {{ $subscribers->currentPage() }} of {{ $subscribers->lastPage() }}</span>
            @if($subscribers->nextPageUrl())
                <a href="{{ $subscribers->nextPageUrl() }}" class="pager-btn">Next &rarr;</a>
            @endif
        </div>
    @endif
@endsection