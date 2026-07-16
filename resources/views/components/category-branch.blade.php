@props(['category', 'depth' => 0])

@if($category->children->isNotEmpty())
    <details class="mm-accordion @if($depth > 0) mm-accordion--nested @endif">
        <summary style="padding-left: {{ 20 + $depth * 16 }}px">
            <span class="mm-summary-label">
                @if($depth === 0 && $category->image)
                    <img src="{{ str($category->image)->startsWith(['http://','https://']) ? $category->image : asset($category->image) }}" alt="" class="mm-category-image">
                @elseif($depth === 0 && $category->icon)
                    <x-icon :name="$category->icon" :size="18" />
                @endif
                {{ $category->label }}
            </span>
            <x-icon name="chevron-down" :size="18" />
        </summary>
        <div class="mm-sublist">
            @foreach($category->children as $child)
                <x-category-branch :category="$child" :depth="$depth + 1" />
            @endforeach
        </div>
    </details>
@else
    <a class="mm-sublist-link" href="{{ route('category.show', $category) }}" style="padding-left: {{ 40 + $depth * 16 }}px">
        {{ $category->label }}
    </a>
@endif