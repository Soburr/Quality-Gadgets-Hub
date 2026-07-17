<nav class="category-nav">
    <div class="wrap">
        <a href="{{ route('home') }}"><span class="dot"></span>All Phones</a>
        @foreach($navCategories ?? [] as $category)
            <a href="{{ route('category.show', $category) }}"><span class="dot"></span>{{ $category->label }}</a>
        @endforeach
    </div>
</nav>