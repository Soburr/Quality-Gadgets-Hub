@props(['category'])

<a href="{{ route('category.show', $category->slug) }}" class="cat-tile">
    <div class="ring-frame">
        <svg class="ring" viewBox="0 0 100 100"><circle cx="50" cy="50" r="42" fill="none" stroke="#8C0027" stroke-opacity="0.25" stroke-width="8" stroke-dasharray="230 34"/></svg>
        <div class="icon">
            <x-icon :name="$category->icon" :size="24" />
        </div>
    </div>
    <span>{{ $category->label }}</span>
</a>