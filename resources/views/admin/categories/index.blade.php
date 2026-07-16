@extends('admin.layout')

@section('title', 'Categories — Admin')

@section('content')
    <div class="admin-header">
        <h1>Categories</h1>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">+ New Category</a>
    </div>

    <div class="cat-tree">
        @forelse($categories as $category)
            <div class="cat-tree-row" style="padding-left: {{ 20 + $category->depth * 26 }}px">
                <div class="cat-tree-name">
                    @if($category->depth === 0)
                        <span class="cat-tree-swatch">
                            @if($category->image)
                                <img src="{{ str($category->image)->startsWith(['http://','https://']) ? $category->image : asset($category->image) }}" alt="">
                            @elseif($category->icon)
                                <x-icon :name="$category->icon" :size="16" />
                            @endif
                        </span>
                    @endif
                    <span class="cat-tree-label @if($category->depth === 0) cat-tree-label--top @endif">{{ $category->label }}</span>
                </div>

                <div class="cat-tree-meta">
                    <span>{{ $category->products()->count() }} products</span>
                    <span>{{ $category->children()->count() }} sub</span>
                </div>

                <div class="cat-tree-actions">
                    <a href="{{ route('admin.categories.create', ['parent_id' => $category->id]) }}" title="Add subcategory" aria-label="Add subcategory under {{ $category->label }}">
                        <x-icon name="plus" :size="15" />
                    </a>
                    <a href="{{ route('admin.categories.edit', $category) }}" title="Edit" aria-label="Edit {{ $category->label }}">
                        <x-icon name="edit" :size="15" />
                    </a>
                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Delete this category?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" title="Delete" aria-label="Delete {{ $category->label }}">
                            <x-icon name="trash" :size="15" />
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <p class="admin-empty">No categories yet.</p>
        @endforelse
    </div>
@endsection