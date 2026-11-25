@extends('admin.layout')

@section('title', 'Email Campaigns — Admin')

@section('content')
    <div class="admin-header">
        <h1>Email Campaigns</h1>
        <a href="{{ route('admin.campaigns.create') }}" class="btn btn-primary">+ New Campaign</a>
    </div>

    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Subject</th>
                    <th>Status</th>
                    <th>Delivered</th>
                    <th>Created</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($campaigns as $campaign)
                    @php
                        $badge = match($campaign->status) {
                            'sending' => 'admin-badge--processing',
                            'sent' => 'admin-badge--delivered',
                            default => '',
                        };
                    @endphp
                    <tr>
                        <td><a href="{{ route('admin.campaigns.show', $campaign) }}" style="color:var(--wine);font-weight:700;">{{ \Illuminate\Support\Str::limit($campaign->subject, 60) }}</a></td>
                        <td><span class="admin-badge {{ $badge }}">{{ ucfirst($campaign->status) }}</span></td>
                        <td>{{ $campaign->status === 'draft' ? '—' : $campaign->sent_count.' / '.$campaign->recipients_count }}</td>
                        <td>{{ $campaign->created_at->format('d M Y') }}</td>
                        <td class="admin-table-actions">
                            <a href="{{ route('admin.campaigns.show', $campaign) }}">Open</a>
                            <form action="{{ route('admin.campaigns.destroy', $campaign) }}" method="POST" onsubmit="return confirm('Delete this campaign?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="admin-empty">No campaigns yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($campaigns->hasPages())
        <div class="pager">
            @if($campaigns->previousPageUrl())
                <a href="{{ $campaigns->previousPageUrl() }}" class="pager-btn">&larr; Prev</a>
            @endif
            <span class="pager-info">Page {{ $campaigns->currentPage() }} of {{ $campaigns->lastPage() }}</span>
            @if($campaigns->nextPageUrl())
                <a href="{{ $campaigns->nextPageUrl() }}" class="pager-btn">Next &rarr;</a>
            @endif
        </div>
    @endif
@endsection