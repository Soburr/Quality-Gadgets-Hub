@php $brand = $brand ?? null; @endphp

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
            <label for="name">Brand name</label>
            <input type="text" id="name" name="name" value="{{ old('name', $brand->name ?? '') }}" required>
        </div>

        <div class="admin-field">
            <label for="sort_order">Sort order</label>
            <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order', $brand->sort_order ?? 0) }}" min="0">
        </div>
    </div>

    <div class="admin-form-side">
        <div class="admin-field">
            <label>Brand logo</label>
            <div class="admin-image-drop-wrap">
                <label for="logo" class="admin-image-drop @if(!empty($brand?->logo)) has-image @endif" id="logoDrop">
                    <img id="logoPreview" src="{{ !empty($brand?->logo) ? (str($brand->logo)->startsWith(['http://','https://']) ? $brand->logo : asset($brand->logo)) : '' }}" alt="">
                    <span class="admin-image-drop-label">Click to choose logo</span>
                </label>
                <button type="button" class="admin-image-remove @if(empty($brand?->logo)) is-hidden @endif" id="logoRemove" aria-label="Remove selected logo">&times;</button>
            </div>
            <input type="file" id="logo" name="logo" accept="image/*" class="admin-file-hidden">
            <input type="hidden" name="remove_logo" id="removeLogoFlag" value="0">
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    var logoInput = document.getElementById('logo');
    var logoDrop = document.getElementById('logoDrop');
    var logoPreview = document.getElementById('logoPreview');
    var logoRemoveBtn = document.getElementById('logoRemove');
    var removeLogoFlag = document.getElementById('removeLogoFlag');

    logoInput.addEventListener('change', function () {
        var file = logoInput.files[0];
        if (!file) return;
        logoPreview.src = URL.createObjectURL(file);
        logoDrop.classList.add('has-image');
        logoRemoveBtn.classList.remove('is-hidden');
        removeLogoFlag.value = '0';
    });

    logoRemoveBtn.addEventListener('click', function () {
        logoInput.value = '';
        logoPreview.src = '';
        logoDrop.classList.remove('has-image');
        logoRemoveBtn.classList.add('is-hidden');
        removeLogoFlag.value = '1';
    });
});
</script>
@endpush