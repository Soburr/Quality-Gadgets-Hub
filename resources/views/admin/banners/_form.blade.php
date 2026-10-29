@php $banner = $banner ?? null; @endphp

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
            <label for="title">Headline (optional)</label>
            <input type="text" id="title" name="title" value="{{ old('title', $banner->title ?? '') }}" placeholder="iPhone 18 Series is here">
        </div>

        <div class="admin-field">
            <label for="subtitle">Subtext (optional)</label>
            <input type="text" id="subtitle" name="subtitle" value="{{ old('subtitle', $banner->subtitle ?? '') }}" placeholder="Pre-order now. Limited stock.">
        </div>

        <div class="admin-field-row">
            <div class="admin-field">
                <label for="button_text">Button text (optional)</label>
                <input type="text" id="button_text" name="button_text" value="{{ old('button_text', $banner->button_text ?? '') }}" placeholder="Shop iPhone 18">
            </div>
            <div class="admin-field">
                <label for="link_url">Link (optional)</label>
                <input type="text" id="link_url" name="link_url" value="{{ old('link_url', $banner->link_url ?? '') }}" placeholder="/category/2">
            </div>
        </div>
        <p class="admin-hint" style="margin-top:-6px;">
            Use /category/2 style paths for pages on this site, or a full https:// link. If you designed the graphic with text already on it, leave the headline, subtext and button blank. The whole banner will still be clickable if a link is set.
        </p>

        <div class="admin-field-row">
            <div class="admin-field">
                <label for="sort_order">Order</label>
                <input type="number" id="sort_order" name="sort_order" min="0" value="{{ old('sort_order', $banner->sort_order ?? 0) }}">
            </div>
        </div>

        <div class="admin-field">
            <label class="flash-sale-toggle">
                <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $banner->is_active ?? true))>
                <span>Show this banner on the homepage</span>
            </label>
        </div>
    </div>

    <div class="admin-form-side">
        <div class="admin-field">
            <label for="image">Banner image {{ $banner ? '' : '(required)' }}</label>
            <label for="image" class="admin-banner-drop" id="bannerDrop">
                <img id="bannerPreview" src="{{ !empty($banner?->image) ? (str($banner->image)->startsWith(['http://','https://']) ? $banner->image : asset($banner->image)) : '' }}" alt="" style="{{ !empty($banner?->image) ? '' : 'display:none;' }}">
                <span id="bannerDropLabel" style="{{ !empty($banner?->image) ? 'display:none;' : '' }}">Click to choose image</span>
            </label>
            <input type="file" id="image" name="image" accept="image/*" class="admin-file-hidden" {{ $banner ? '' : 'required' }}>
            <p class="admin-hint">Best size: 1600 × 600 px, landscape. On phones the sides get cropped, so keep the important part (the phone, the text) in the middle.</p>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    var input = document.getElementById('image');
    var preview = document.getElementById('bannerPreview');
    var label = document.getElementById('bannerDropLabel');

    input.addEventListener('change', function () {
        var file = input.files[0];
        if (!file) return;
        preview.src = URL.createObjectURL(file);
        preview.style.display = 'block';
        label.style.display = 'none';
    });
});
</script>
@endpush