@if($errors->any())
    <div class="auth-error">
        @foreach($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
@endif

<div class="admin-form-grid">
    <div class="admin-form-main">
        <div class="admin-field">
            <label for="label">Category name</label>
            <input type="text" id="label" name="label" value="{{ old('label', $category->label ?? '') }}" required>
        </div>

        <div class="admin-field">
            <label for="parent_id">Parent category</label>
            <select id="parent_id" name="parent_id">
                <option value="">None (top-level)</option>
                @foreach($parents as $parent)
                    <option value="{{ $parent->id }}" @selected($selectedParentId == $parent->id)>
                        {{ str_repeat('— ', $parent->depth) }}{{ $parent->label }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="admin-field">
            <label for="icon">Icon (fallback shown if no image is uploaded)</label>
            <select id="icon" name="icon">
                <option value="">None</option>
                @foreach(['phone','tablet','watch','earbud','battery','plug','case','shield','refresh','game','signal','dots'] as $iconName)
                    <option value="{{ $iconName }}" @selected(old('icon', $category->icon ?? '') === $iconName)>{{ ucfirst($iconName) }}</option>
                @endforeach
            </select>
        </div>

        <div class="admin-field">
            <label for="sort_order">Sort order</label>
            <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order', $category->sort_order ?? 0) }}" min="0">
        </div>
    </div>

    <div class="admin-form-side">
        <div class="admin-field">
            <label for="image">Category image</label>
            @if(!empty($category?->image))
                <img src="{{ str($category->image)->startsWith(['http://','https://']) ? $category->image : asset($category->image) }}" alt="" class="admin-current-image">
            @endif
            <input type="file" id="image" name="image" accept="image/*">
            <p class="admin-hint">Used on the homepage category grid and mobile menu — mainly matters for top-level categories like Phone, Gadgets, Laptop.</p>
        </div>
    </div>
</div>