<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::flattenedForSelect();

        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        $parents = Category::flattenedForSelect();

        return view('admin.categories.create', compact('parents'));
    }

    public function store(Request $request)
    {
        $validated = $this->validated($request);
        $validated['slug'] = $this->uniqueSlug($validated['label'], $validated['parent_id']);

        if ($request->hasFile('image')) {
            $validated['image'] = $this->storeImage($request->file('image'));
        }

        Category::create($validated);

        return redirect()->route('admin.categories.index')->with('status', 'Category created.');
    }

    public function edit(Category $category)
    {
        $excludeIds = $category->allDescendantIds();
        $parents = Category::flattenedForSelect()->reject(fn ($cat) => in_array($cat->id, $excludeIds));

        return view('admin.categories.edit', compact('category', 'parents'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $this->validated($request);

        if ($validated['label'] !== $category->label || (int) $validated['parent_id'] !== (int) $category->parent_id) {
            $validated['slug'] = $this->uniqueSlug($validated['label'], $validated['parent_id'], $category->id);
        }

        if ($request->hasFile('image')) {
            $validated['image'] = $this->storeImage($request->file('image'));
        }

        $category->update($validated);

        return redirect()->route('admin.categories.index')->with('status', 'Category updated.');
    }

    public function destroy(Category $category)
    {
        if ($category->children()->exists()) {
            return back()->with('status', 'This category still has subcategories — move or delete those first.');
        }

        if ($category->products()->exists()) {
            return back()->with('status', 'This category still has products — reassign them to another category first.');
        }

        $category->delete();

        return back()->with('status', 'Category deleted.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'label' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id',
            'icon' => 'nullable|string|max:30',
            'sort_order' => 'nullable|integer|min:0',
            'image' => 'nullable|image|max:4096',
        ]);
    }

    private function storeImage($file): string
    {
        return Storage::url($file->store('categories', 'public'));
    }

    private function uniqueSlug(string $label, ?int $parentId, ?int $ignoreId = null): string
    {
        $base = Str::slug($label);
        $slug = $base;
        $i = 1;

        while (
            Category::where('slug', $slug)
                ->when(
                    $parentId === null,
                    fn ($q) => $q->whereNull('parent_id'),
                    fn ($q) => $q->where('parent_id', $parentId)
                )
                ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = $base.'-'.$i++;
        }

        return $slug;
    }
}