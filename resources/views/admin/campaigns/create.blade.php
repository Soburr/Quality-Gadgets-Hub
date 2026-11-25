@extends('admin.layout')

@section('title', 'New Campaign — Admin')

@section('content')
    <div class="admin-header">
        <h1>New Campaign</h1>
    </div>

    @if($errors->any())
        <div class="auth-error">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form action="{{ route('admin.campaigns.store') }}" method="POST" class="admin-form" style="max-width:720px;">
        @csrf

        <p class="admin-hint" style="margin-bottom:16px;">
            This will go to <strong>{{ number_format($activeCount) }}</strong> active subscribers.
            @if($activeCount === 0)
                <a href="{{ route('admin.subscribers.index') }}" style="color:var(--wine);font-weight:700;">Import your list first</a>.
            @endif
        </p>

        <div class="admin-field">
            <label for="subject">Subject</label>
            <input type="text" id="subject" name="subject" value="{{ old('subject') }}" maxlength="150" required placeholder="iPhone 18 is now available at Quality Gadgets Hub">
        </div>

        <div class="admin-field">
            <label for="body">Message</label>
            <textarea id="body" name="body" rows="14" required placeholder="Hi {name},&#10;&#10;Write it like a normal email. Press Enter for new lines.">{{ old('body') }}</textarea>
            <p class="admin-hint">
                Plain text. Use <strong>{name}</strong> to insert each person's name (it becomes "there" when we don't have one). Works in the subject too. Every email gets your branded header and an unsubscribe link automatically.
            </p>
        </div>

        <button type="submit" class="btn btn-primary">Save draft &amp; continue</button>
    </form>
@endsection