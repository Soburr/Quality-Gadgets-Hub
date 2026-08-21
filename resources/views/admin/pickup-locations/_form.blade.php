@if($errors->any())
    <div class="auth-error">
        @foreach($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
@endif

<div class="admin-field-row" style="max-width:500px;">
    <div class="admin-field">
        <label for="name">Location name</label>
        <input type="text" id="name" name="name" value="{{ old('name', $location->name ?? '') }}" required>
    </div>
    <div class="admin-field">
        <label for="fee">Fee (&#8358;)</label>
        <input type="number" id="fee" name="fee" value="{{ old('fee', $location->fee ?? 0) }}" required min="0">
    </div>
</div>

<div class="admin-field" style="max-width:240px;">
    <label for="sort_order">Sort order</label>
    <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order', $location->sort_order ?? 0) }}" min="0">
</div>