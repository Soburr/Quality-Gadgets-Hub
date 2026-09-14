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
            <label for="brand_id">Brand (optional)</label>
            <select id="brand_id" name="brand_id">
                <option value="">No brand</option>
                @foreach($brands as $brand)
                    <option value="{{ $brand->id }}" @selected(old('brand_id', $product->brand_id ?? null) == $brand->id)>{{ $brand->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="admin-field">
            <label>Description</label>
            <div class="rte-toolbar">
                <button type="button" class="rte-btn" data-command="bold" title="Bold"><strong>B</strong></button>
                <button type="button" class="rte-btn" data-command="italic" title="Italic"><em>i</em></button>
                <span class="rte-hint">Press Enter for a new paragraph, Shift+Enter for a line break</span>
            </div>
            <div id="descriptionEditor" class="rte-editor" contenteditable="true">{!! old('description', $product->description ?? '') !!}</div>
            <textarea name="description" id="descriptionField" hidden>{{ old('description', $product->description ?? '') }}</textarea>
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

        <div class="admin-field flash-sale-field">
            <label class="flash-sale-toggle">
                <input type="checkbox" name="is_flash_sale" value="1" id="isFlashSale" @checked(old('is_flash_sale', $product->is_flash_sale ?? false))>
                <span>Include in Flash Sale</span>
            </label>
            <div class="admin-field flash-sale-ends" id="flashSaleEndsWrap">
                <label for="flash_sale_ends_at">Flash sale ends at</label>
                <input type="datetime-local" id="flash_sale_ends_at" name="flash_sale_ends_at"
                    value="{{ old('flash_sale_ends_at', isset($product?->flash_sale_ends_at) ? $product->flash_sale_ends_at->format('Y-m-d\TH:i') : '') }}">
                <p class="admin-hint">Leave blank for no expiry — product stays in the flash sale until you turn this off manually.</p>
            </div>
        </div>

        <div class="admin-field">
            <label class="flash-sale-toggle">
                <input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $product->is_featured ?? false))>
                <span>Feature on homepage (Great Finds row)</span>
            </label>
            <p class="admin-hint">Use this to spotlight budget items, accessories, or anything else worth extra visibility — independent of price or flash sale status.</p>
        </div>

        <div class="admin-field">
            <label>Color variants (optional)</label>
            <p class="admin-hint" style="margin-bottom:12px;">Each color can have its own price and photo. Leave price blank to use the base price above; leave photo blank to use the main image.</p>

            @if($savedColors->isNotEmpty())
                <div class="saved-colors">
                    <span class="saved-colors-label">Saved colors — click to add a variant</span>
                    <div class="saved-colors-list">
                        @foreach($savedColors as $swatch)
                            <button type="button" class="saved-color-btn" data-name="{{ $swatch->name }}" data-hex="{{ $swatch->hex }}">
                                <span class="saved-color-swatch" style="background:{{ $swatch->hex }}"></span>
                                <span class="saved-color-name">{{ $swatch->name }}</span>
                                <span class="saved-color-plus">+</span>
                            </button>
                        @endforeach
                    </div>
                </div>
            @endif

            <div id="colorVariantsList" class="color-variants-list"></div>
            <button type="button" id="addColorVariantBtn" class="btn btn-ghost" style="margin-top:10px;">+ Add color variant</button>
        </div>

        <script type="application/json" id="colorsExistingField">{!! json_encode(collect($product->colors ?? [])->map(function ($c) {
            $raw = $c['image'] ?? null;
            $gallery = $c['gallery'] ?? [];
            return [
                'name' => $c['name'] ?? '',
                'hex' => $c['hex'] ?? '#000000',
                'price' => $c['price'] ?? null,
                'image' => $raw,
                'image_url' => $raw ? (str($raw)->startsWith(['http://', 'https://']) ? $raw : asset($raw)) : null,
                'gallery' => $gallery,
                'gallery_urls' => collect($gallery)->map(fn ($g) => str($g)->startsWith(['http://', 'https://']) ? $g : asset($g))->values(),
            ];
        })->values()) !!}</script>

                <template id="colorVariantTemplate">
            <div class="color-variant-row" data-index="__INDEX__">
                <div class="color-variant-top">
                    <input type="color" name="colors[__INDEX__][hex]" value="#8C0027" class="cv-hex">
                    <input type="text" name="colors[__INDEX__][name]" placeholder="Color name (e.g. Red)" class="cv-name">
                    <div class="cv-price-wrap">
                        <span>&#8358;</span>
                        <input type="number" name="colors[__INDEX__][price]" min="0" placeholder="Same as base price" class="cv-price">
                    </div>
                    <button type="button" class="cv-remove" aria-label="Remove this color">&times;</button>
                </div>
                <div class="cv-image-row">
                    <div class="cv-image-block">
                        <span class="cv-block-label">Main photo</span>
                        <div class="admin-image-drop-wrap cv-image-wrap">
                            <label for="cvImage__INDEX__" class="admin-image-drop admin-image-drop--sm cv-image-drop">
                                <img class="cv-image-preview" src="" alt="" style="display:none;">
                                <span class="admin-image-drop-label cv-image-label">Add photo</span>
                            </label>
                            <button type="button" class="admin-image-remove is-hidden cv-image-remove-btn" aria-label="Remove photo">&times;</button>
                        </div>
                        <input type="file" id="cvImage__INDEX__" name="colors[__INDEX__][image]" accept="image/*" class="admin-file-hidden cv-image-input">
                        <input type="hidden" name="colors[__INDEX__][existing_image]" value="" class="cv-existing-image">
                        <input type="hidden" name="colors[__INDEX__][remove_image]" value="0" class="cv-remove-image-flag">
                    </div>

                    <div class="cv-image-block cv-gallery-block">
                        <span class="cv-block-label">Other images (optional)</span>
                        <div class="cv-gallery-strip"></div>
                        <label for="cvGallery__INDEX__" class="btn btn-ghost cv-gallery-choose">+ Add images</label>
                        <input type="file" id="cvGallery__INDEX__" name="colors[__INDEX__][gallery][]" accept="image/*" multiple class="admin-file-hidden cv-gallery-input">
                        <input type="hidden" name="colors[__INDEX__][existing_gallery]" value="[]" class="cv-existing-gallery">
                        <input type="hidden" name="colors[__INDEX__][removed_gallery]" value="[]" class="cv-removed-gallery">
                    </div>
                </div>
            </div>
        </template>
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
            <p class="admin-hint">Removed images are deleted when you save. Uploading new gallery images replaces whatever remains.</p>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {

        // ---------- Rich text description editor ----------
        var editor = document.getElementById('descriptionEditor');
        var descriptionField = document.getElementById('descriptionField');

        document.execCommand('defaultParagraphSeparator', false, 'p');

        document.querySelectorAll('.rte-btn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                editor.focus();
                document.execCommand(btn.dataset.command, false, null);
                syncDescription();
            });
        });

        function syncDescription() {
            descriptionField.value = editor.innerHTML;
        }

        editor.addEventListener('input', syncDescription);
        editor.addEventListener('blur', syncDescription);
        syncDescription();

        // ---------- Main image live preview + remove ----------
        var imageInput = document.getElementById('image');
        var imageDrop = document.getElementById('mainImageDrop');
        var imagePreview = document.getElementById('mainImagePreview');
        var imageRemoveBtn = document.getElementById('mainImageRemove');
        var removeImageFlag = document.getElementById('removeImageFlag');

        imageInput.addEventListener('change', function() {
            var file = imageInput.files[0];
            if (!file) return;
            imagePreview.src = URL.createObjectURL(file);
            imageDrop.classList.add('has-image');
            imageRemoveBtn.classList.remove('is-hidden');
            removeImageFlag.value = '0';
        });

        imageRemoveBtn.addEventListener('click', function() {
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

            files.forEach(function(file, index) {
                var item = document.createElement('div');
                item.className = 'admin-gallery-item';

                var img = document.createElement('img');
                img.src = URL.createObjectURL(file);
                item.appendChild(img);

                var removeBtn = document.createElement('button');
                removeBtn.type = 'button';
                removeBtn.className = 'admin-gallery-item-remove';
                removeBtn.setAttribute('aria-label', 'Remove this gallery image');
                removeBtn.addEventListener('click', function() {
                    var current = Array.from(galleryInput.files);
                    current.splice(index, 1);

                    var dataTransfer = new DataTransfer();
                    current.forEach(function(f) {
                        dataTransfer.items.add(f);
                    });
                    galleryInput.files = dataTransfer.files;

                    renderGallery(Array.from(galleryInput.files));
                });
                item.appendChild(removeBtn);

                galleryDrop.appendChild(item);
            });
        }

        galleryInput.addEventListener('change', function() {
            renderGallery(Array.from(galleryInput.files));
        });

        var removedGalleryField = document.getElementById('removedGalleryField');
        var removedGalleryPaths = [];

        document.querySelectorAll('.admin-gallery-drop .admin-gallery-item-remove[data-existing-path]').forEach(function(btn) {
            btn.addEventListener('click', function() {
                removedGalleryPaths.push(btn.dataset.existingPath);
                removedGalleryField.value = JSON.stringify(removedGalleryPaths);
                btn.closest('.admin-gallery-item').remove();
            });
        });

        (function () {
            var list = document.getElementById('colorVariantsList');
            var templateHtml = document.getElementById('colorVariantTemplate').innerHTML;
            var addBtn = document.getElementById('addColorVariantBtn');
            var existingColors = JSON.parse(document.getElementById('colorsExistingField').textContent || '[]');
            var index = 0;

            function addRow(data) {
                data = data || {};
                var html = templateHtml.split('__INDEX__').join(index);
                var wrapper = document.createElement('div');
                wrapper.innerHTML = html.trim();
                var row = wrapper.firstElementChild;
                list.appendChild(row);

                var hexInput = row.querySelector('.cv-hex');
                var nameInput = row.querySelector('.cv-name');
                var priceInput = row.querySelector('.cv-price');
                var imageInput = row.querySelector('.cv-image-input');
                var imagePreview = row.querySelector('.cv-image-preview');
                var imageLabel = row.querySelector('.cv-image-label');
                var existingImageField = row.querySelector('.cv-existing-image');
                var removeImageFlag = row.querySelector('.cv-remove-image-flag');
                var removeImageBtn = row.querySelector('.cv-image-remove-btn');
                var removeRowBtn = row.querySelector('.cv-remove');
                var galleryStrip = row.querySelector('.cv-gallery-strip');
                var galleryInput = row.querySelector('.cv-gallery-input');
                var existingGalleryField = row.querySelector('.cv-existing-gallery');
                var removedGalleryField = row.querySelector('.cv-removed-gallery');
                var removedGalleryPaths = [];
                if (data.hex) hexInput.value = data.hex;
                if (data.name) nameInput.value = data.name;
                if (data.price !== null && data.price !== undefined) priceInput.value = data.price;
                if (data.image_url) {
                    imagePreview.src = data.image_url;
                    imagePreview.style.display = 'block';
                    imageLabel.style.display = 'none';
                    existingImageField.value = data.image;
                    removeImageBtn.classList.remove('is-hidden');
                }

                imageInput.addEventListener('change', function () {
                    var file = imageInput.files[0];
                    if (!file) return;
                    imagePreview.src = URL.createObjectURL(file);
                    imagePreview.style.display = 'block';
                    imageLabel.style.display = 'none';
                    removeImageFlag.value = '0';
                    removeImageBtn.classList.remove('is-hidden');
                });

                removeImageBtn.addEventListener('click', function () {
                    imageInput.value = '';
                    imagePreview.src = '';
                    imagePreview.style.display = 'none';
                    imageLabel.style.display = 'block';
                    existingImageField.value = '';
                    removeImageFlag.value = '1';
                    removeImageBtn.classList.add('is-hidden');
                });

                removeRowBtn.addEventListener('click', function () {
                    row.remove();
                });

                // ---- Variant gallery ----
                function renderSavedGallery() {
                    galleryStrip.innerHTML = '';

                    var saved = JSON.parse(existingGalleryField.value || '[]');
                    var urls = data.gallery_urls || [];

                    saved.forEach(function (path, i) {
                        if (removedGalleryPaths.indexOf(path) !== -1) return;

                        var item = document.createElement('div');
                        item.className = 'cv-gallery-item';

                        var img = document.createElement('img');
                        img.src = urls[i] || path;
                        item.appendChild(img);

                        var rm = document.createElement('button');
                        rm.type = 'button';
                        rm.className = 'cv-gallery-remove';
                        rm.innerHTML = '&times;';
                        rm.setAttribute('aria-label', 'Remove this image');
                        rm.addEventListener('click', function () {
                            removedGalleryPaths.push(path);
                            removedGalleryField.value = JSON.stringify(removedGalleryPaths);
                            renderSavedGallery();
                        });
                        item.appendChild(rm);

                        galleryStrip.appendChild(item);
                    });

                    Array.from(galleryInput.files).forEach(function (file) {
                        var item = document.createElement('div');
                        item.className = 'cv-gallery-item cv-gallery-item--new';
                        var img = document.createElement('img');
                        img.src = URL.createObjectURL(file);
                        item.appendChild(img);
                        galleryStrip.appendChild(item);
                    });

                    if (!galleryStrip.children.length) {
                        var empty = document.createElement('span');
                        empty.className = 'cv-gallery-empty';
                        empty.textContent = 'No extra images yet';
                        galleryStrip.appendChild(empty);
                    }
                }

                if (data.gallery && data.gallery.length) {
                    existingGalleryField.value = JSON.stringify(data.gallery);
                }

                galleryInput.addEventListener('change', renderSavedGallery);
                renderSavedGallery();

                index++;
            }

            existingColors.forEach(function (c) { addRow(c); });
            addBtn.addEventListener('click', function () { addRow(); });

            document.querySelectorAll('.saved-color-btn').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    addRow({ name: btn.dataset.name, hex: btn.dataset.hex });
                });
            });
        })();

        // ---------- Flash sale toggle ----------
        var flashCheckbox = document.getElementById('isFlashSale');
        var flashEndsWrap = document.getElementById('flashSaleEndsWrap');

        function toggleFlashEndsField() {
            flashEndsWrap.style.display = flashCheckbox.checked ? 'block' : 'none';
        }

        flashCheckbox.addEventListener('change', toggleFlashEndsField);
        toggleFlashEndsField();

    });
</script>
@endpush