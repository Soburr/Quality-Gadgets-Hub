@extends('admin.layout')

@section('title', $campaign->subject.' — Admin')

@section('content')
    @php
        $done = $counts['sent'] + $counts['failed'] + $counts['skipped'];
        $percent = $counts['total'] > 0 ? round($done / $counts['total'] * 100) : 0;
        $badge = match($campaign->status) {
            'sending' => 'admin-badge--processing',
            'sent' => 'admin-badge--delivered',
            default => '',
        };
    @endphp

    <div class="admin-header">
        <h1>{{ \Illuminate\Support\Str::limit($campaign->subject, 60) }}</h1>
        <span class="admin-badge {{ $badge }}">{{ ucfirst($campaign->status) }}</span>
    </div>

    @if($errors->any())
        <div class="auth-error">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <div class="admin-panel" style="margin-bottom:24px;">
        <h3>Message</h3>
        <p style="margin:0 0 8px;font-size:13px;"><strong>Subject:</strong> {{ $campaign->subject }}</p>
        <div class="campaign-preview">{!! nl2br(e($campaign->body)) !!}</div>
    </div>

    @if($campaign->status === 'draft')
        <div class="admin-panels">
            <div class="admin-panel">
                <h3>1. Send yourself a test</h3>
                <form action="{{ route('admin.campaigns.test', $campaign) }}" method="POST" class="admin-form">
                    @csrf
                    <div class="admin-field">
                        <label for="test_email">Send test to</label>
                        <input type="text" id="test_email" name="test_email" value="{{ old('test_email', auth()->user()->email) }}" required>
                    </div>
                    <button type="submit" class="btn btn-ghost">Send test</button>
                </form>
            </div>

            <div class="admin-panel">
                <h3>2. Send to your list</h3>
                <p class="admin-hint" style="margin-bottom:14px;">
                    This will email <strong>{{ number_format($activeCount) }}</strong> active subscribers. The list is locked in at the moment you press the button.
                </p>
                <form action="{{ route('admin.campaigns.start', $campaign) }}" method="POST" onsubmit="return confirm('Prepare this campaign for {{ $activeCount }} subscribers?');">
                    @csrf
                    <button type="submit" class="btn btn-primary" @disabled($activeCount === 0)>Prepare to send</button>
                </form>
            </div>
        </div>
    @else
        <div class="campaign-stats">
            <div class="campaign-stat"><span>Total</span><strong id="statTotal">{{ number_format($counts['total']) }}</strong></div>
            <div class="campaign-stat"><span>Sent</span><strong id="statSent">{{ number_format($counts['sent']) }}</strong></div>
            <div class="campaign-stat"><span>Waiting</span><strong id="statPending">{{ number_format($counts['pending']) }}</strong></div>
            <div class="campaign-stat"><span>Failed</span><strong id="statFailed">{{ number_format($counts['failed']) }}</strong></div>
        </div>

        <div class="campaign-progress"><div class="campaign-progress-fill" id="progressFill" style="width:{{ $percent }}%"></div></div>

        @if($campaign->status === 'sending')
            <div class="admin-panel">
                <button type="button" id="sendBatchBtn" class="btn btn-primary">
                    {{ $counts['sent'] + $counts['failed'] > 0 ? 'Continue sending' : 'Start sending' }}
                </button>
                <p class="admin-hint" id="batchStatus" style="margin-top:12px;">
                    Keep this tab open while it sends. Closing it just pauses. Come back and press Continue.
                </p>
            </div>
        @else
            <div class="order-note-callout" style="margin:0 0 20px;">
                <strong>Finished</strong>
                <p>Sent to {{ number_format($counts['sent']) }} of {{ number_format($counts['total']) }} people{{ $campaign->finished_at ? ' on '.$campaign->finished_at->format('d M Y, h:ia') : '' }}.</p>
            </div>
        @endif

        @if($counts['failed'] > 0)
            <form action="{{ route('admin.campaigns.retry', $campaign) }}" method="POST" style="margin-bottom:20px;">
                @csrf
                <button type="submit" class="btn btn-ghost">Retry {{ $counts['failed'] }} failed</button>
            </form>

            <div class="admin-panel">
                <h3>Failed emails @if($counts['failed'] > 20)<span class="admin-hint" style="display:inline;">(first 20)</span>@endif</h3>
                @foreach($failures as $failure)
                    <div class="admin-panel-row" style="display:block;">
                        <strong style="color:var(--ink);">{{ $failure->subscriber?->email ?? 'removed subscriber' }}</strong>
                        <div class="admin-hint" style="margin:2px 0 0;">{{ $failure->error }}</div>
                    </div>
                @endforeach
            </div>
        @endif
    @endif
@endsection

@if($campaign->status === 'sending')
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    var btn = document.getElementById('sendBatchBtn');
    var statusEl = document.getElementById('batchStatus');
    var url = '{{ route('admin.campaigns.batch', $campaign) }}';
    var token = '{{ csrf_token() }}';

    function setText(id, value) {
        var el = document.getElementById(id);
        if (el) el.textContent = Number(value).toLocaleString();
    }

    function render(data) {
        setText('statTotal', data.total);
        setText('statSent', data.sent);
        setText('statPending', data.pending);
        setText('statFailed', data.failed);
        var done = data.sent + data.failed + data.skipped;
        var pct = data.total > 0 ? Math.round(done / data.total * 100) : 0;
        document.getElementById('progressFill').style.width = pct + '%';
        statusEl.textContent = 'Sending... ' + pct + '% (' + data.sent.toLocaleString() + ' sent). Keep this tab open.';
    }

    btn.addEventListener('click', async function () {
        btn.disabled = true;
        statusEl.textContent = 'Starting...';

        while (true) {
            var res;
            try {
                res = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
            } catch (e) {
                statusEl.textContent = 'Connection lost. Nothing is double-sent. Press Continue to resume.';
                break;
            }

            if (!res.ok) {
                statusEl.textContent = 'Server error (' + res.status + '). Press Continue to try again.';
                break;
            }

            var data = await res.json();
            render(data);

            if (data.halted) {
                statusEl.textContent = 'Stopped after repeated failures: ' + (data.error || 'unknown error') + '. Fix the mail settings, then press Retry failed.';
                break;
            }

            if (data.pending === 0) {
                statusEl.textContent = 'All done. Refreshing...';
                setTimeout(function () { location.reload(); }, 800);
                return;
            }
        }

        btn.disabled = false;
        btn.textContent = 'Continue sending';
    });
});
</script>
@endpush
@endif