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
            <label>Color options (optional)</label>
            <div class="color-builder">
                <div class="color-builder-list" id="colorBuilderList"></div>
                <div class="color-builder-add">
                    <input type="color" id="colorPickerInput" value="#8C0027">
                    <input type="text" id="colorNameInput" placeholder="Color name (e.g. Midnight)">
                    <button type="button" id="colorAddBtn" class="btn btn-ghost">+ Add color</button>
                </div>
            </div>
            <textarea name="colors_raw" id="colorsRawField" hidden>{{ old('colors_raw', isset($product->colors) ? collect($product->colors)->map(fn($c) => $c['name'].':'.$c['hex'])->implode("\n") : '') }}</textarea>
            <p class="admin-hint">Pick a color, name it, and add it — no hex codes to type.</p>
        </div>
    </div>

    <div class="admin-form-side">
        <div class="admin-field">
            <label>Main image</label>
            <div class="admin-image-drop-wrap">
                <label for="image" class="admin-image-drop @if(!empty($product?->image)) has-image @endif" id="mainImageDrop">
                    <img id="mainImagePreview" src="{{ !empty($product?->image) ? (str($product->image)->startsWith(['http://','https://']) ? $product->image : asset($product->image)) : '' }}" alt="">
                    <span class="admin-image-drop-label">Click to choose image</span>
                </label>
                <button type="button" class="admin-image-remove @if(empty($product?->image)) is-hidden @endif" id="mainImageRemove" aria-label="Remove selected image">&times;</button>
            </div>
            <input type="file" id="image" name="image" accept="image/*" class="admin-file-hidden">
            <input type="hidden" name="remove_image" id="removeImageFlag" value="0">
        </div>

        <div class="admin-field">
            <label for="gallery">Gallery images (optional, multiple)</label>
            <div class="admin-gallery-drop" id="galleryDrop">
                @forelse($product->gallery ?? [] as $img)
                    <div class="admin-gallery-item">
                        <img src="{{ str($img)->startsWith(['http://','https://']) ? $img : asset($img) }}" alt="">
                        <button type="button" class="admin-gallery-item-remove" data-existing-path="{{ $img }}" aria-label="Remove this gallery image">&times;</button>
                    </div>
                @empty
                    <span class="admin-gallery-empty">No gallery images yet</span>
                @endforelse
            </div>
            <label for="gallery" class="btn btn-ghost admin-gallery-choose">Choose gallery images</label>
            <input type="file" id="gallery" name="gallery[]" accept="image/*" multiple class="admin-file-hidden">
            <input type="hidden" name="removed_gallery" id="removedGalleryField" value="[]">
            <p class="admin-hint">
                Removed images are deleted when you save. 
                Uploading new gallery images replaces whatever remains.
            </p>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    // ---------- Main image live preview + remove ----------
    var imageInput = document.getElementById('image');
    var imageDrop = document.getElementById('mainImageDrop');
    var imagePreview = document.getElementById('mainImagePreview');
    var imageRemoveBtn = document.getElementById('mainImageRemove');
    var removeImageFlag = document.getElementById('removeImageFlag');

    imageInput.addEventListener('change', function () {
        var file = imageInput.files[0];
        if (!file) return;
        imagePreview.src = URL.createObjectURL(file);
        imageDrop.classList.add('has-image');
        imageRemoveBtn.classList.remove('is-hidden');
        removeImageFlag.value = '0';
    });

    imageRemoveBtn.addEventListener('click', function () {
        imageInput.value = '';
        imagePreview.src = '';
        imageDrop.classList.remove('has-image');
        imageRemoveBtn.classList.add('is-hidden');
        removeImageFlag.value = '1';
    });

    // ---------- Gallery live preview + remove ----------
    var galleryInput = document.getElementById('gallery');
    var galleryDrop = document.getElementById('galleryDrop');

    function renderGallery(files) {
        galleryDrop.innerHTML = '';

        if (files.length === 0) {
            var empty = document.createElement('span');
            empty.className = 'admin-gallery-empty';
            empty.textContent = 'No gallery images yet';
            galleryDrop.appendChild(empty);
            return;
        }

        files.forEach(function (file, index) {
            var item = document.createElement('div');
            item.className = 'admin-gallery-item';

            var img = document.createElement('img');
            img.src = URL.createObjectURL(file);
            item.appendChild(img);

            var removeBtn = document.createElement('button');
            removeBtn.type = 'button';
            removeBtn.className = 'admin-gallery-item-remove';
            removeBtn.setAttribute('aria-label', 'Remove this gallery image');
            removeBtn.addEventListener('click', function () {
                var current = Array.from(galleryInput.files);
                current.splice(index, 1);

                var dataTransfer = new DataTransfer();
                current.forEach(function (f) { dataTransfer.items.add(f); });
                galleryInput.files = dataTransfer.files;

                renderGallery(Array.from(galleryInput.files));
            });
            item.appendChild(removeBtn);

            galleryDrop.appendChild(item);
        });
    }

    galleryInput.addEventListener('change', function () {
        renderGallery(Array.from(galleryInput.files));
    });

    var removedGalleryField = document.getElementById('removedGalleryField');
    var removedGalleryPaths = [];

    document.querySelectorAll('.admin-gallery-drop .admin-gallery-item-remove[data-existing-path]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            removedGalleryPaths.push(btn.dataset.existingPath);
            removedGalleryField.value = JSON.stringify(removedGalleryPaths);
            btn.closest('.admin-gallery-item').remove();
        });
    });

    // ---------- Color builder ----------
    var list = document.getElementById('colorBuilderList');
    var rawField = document.getElementById('colorsRawField');
    var nameInput = document.getElementById('colorNameInput');
    var pickerInput = document.getElementById('colorPickerInput');
    var addBtn = document.getElementById('colorAddBtn');

    var colors = rawField.value
        .split('\n')
        .map(function (line) { return line.trim(); })
        .filter(Boolean)
        .map(function (line) {
            var parts = line.split(':');
            return { name: (parts[0] || '').trim(), hex: (parts[1] || '#000000').trim() };
        });

    function renderColors() {
        list.innerHTML = '';
        colors.forEach(function (color, index) {
            var item = document.createElement('div');
            item.className = 'color-builder-item';
            item.innerHTML =
                '<span class="color-builder-swatch" style="background:' + color.hex + '"></span>' +
                '<span class="color-builder-name">' + color.name + '</span>' +
                '<button type="button" class="color-builder-remove" aria-label="Remove ' + color.name + '">&times;</button>';
            item.querySelector('.color-builder-remove').addEventListener('click', function () {
                colors.splice(index, 1);
                syncColors();
            });
            list.appendChild(item);
        });
    }

    function syncColors() {
        rawField.value = colors.map(function (c) { return c.name + ':' + c.hex; }).join('\n');
        renderColors();
    }

    addBtn.addEventListener('click', function () {
        var name = nameInput.value.trim();
        if (!name) {
            nameInput.focus();
            return;
        }
        colors.push({ name: name, hex: pickerInput.value });
        nameInput.value = '';
        syncColors();
    });

    nameInput.addEventListener('keydown', function (e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            addBtn.click();
        }
    });

    renderColors();

});
</script>
@endpush