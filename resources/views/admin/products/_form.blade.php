@php $product = $product ?? null; @endphp

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
            <label for="name">Product name</label>
            <input type="text" id="name" name="name" value="{{ old('name', $product->name ?? '') }}" required>
        </div>

        <div class="admin-field">
            <label for="category_id">Category</label>
            <select id="category_id" name="category_id" required>
                <option value="">Select a category</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" @selected(old('category_id', $product->category_id ?? null) == $cat->id)>
                        {{ str_repeat('— ', $cat->depth) }}{{ $cat->label }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="admin-field">
            <label for="description">Description</label>
            <textarea id="description" name="description" rows="5">{{ old('description', $product->description ?? '') }}</textarea>
        </div>

        <div class="admin-field-row">
            <div class="admin-field">
                <label for="price">Price (&#8358;)</label>
                <input type="number" id="price" name="price" value="{{ old('price', $product->price ?? '') }}" required min="0">
            </div>
            <div class="admin-field">
                <label for="was_price">Was price (optional)</label>
                <input type="number" id="was_price" name="was_price" value="{{ old('was_price', $product->was_price ?? '') }}" min="0">
            </div>
        </div>

        <div class="admin-field-row">
            <div class="admin-field">
                <label for="stock">Stock quantity</label>
                <input type="number" id="stock" name="stock" value="{{ old('stock', $product->stock ?? 0) }}" required min="0">
            </div>
            <div class="admin-field">
                <label for="badge">Badge (optional)</label>
                <input type="text" id="badge" name="badge" value="{{ old('badge', $product->badge ?? '') }}" placeholder="New, Verified, -10%">
            </div>
        </div>

        <div class="admin-field">
            <label for="colors_raw">Color options (optional — one per line, "Name:#hex")</label>
            <textarea id="colors_raw" name="colors_raw" rows="4" placeholder="Midnight:#1d1d1f&#10;Starlight:#f0e6d8">{{ old('colors_raw', isset($product->colors) ? collect($product->colors)->map(fn($c) => $c['name'].':'.$c['hex'])->implode("\n") : '') }}</textarea>
        </div>
    </div>

    <div class="admin-form-side">
        <div class="admin-field">
            <label for="image">Main image</label>
            @if(!empty($product?->image))
                <img src="{{ str($product->image)->startsWith(['http://','https://']) ? $product->image : asset($product->image) }}" alt="" class="admin-current-image">
            @endif
            <input type="file" id="image" name="image" accept="image/*">
        </div>

        <div class="admin-field">
            <label for="gallery">Gallery images (optional, multiple)</label>
            @if(!empty($product?->gallery))
                <div class="admin-gallery-preview">
                    @foreach($product->gallery as $img)
                        <img src="{{ str($img)->startsWith(['http://','https://']) ? $img : asset($img) }}" alt="">
                    @endforeach
                </div>
            @endif
            <input type="file" id="gallery" name="gallery[]" accept="image/*" multiple>
            <p class="admin-hint">Uploading new gallery images replaces the existing set.</p>
        </div>
    </div>
</div>