<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::with('category')
            ->when($request->get('q'), fn ($q, $term) => $q->where('name', 'like', "%{$term}%"))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::flattenedForSelect();

        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $this->validated($request);

        $validated['slug'] = $this->uniqueSlug($validated['name']);
        $validated['colors'] = $this->parseColors($request->input('colors_raw'));

        if ($request->hasFile('image')) {
            $validated['image'] = $this->storeImage($request->file('image'));
        }
        if ($request->hasFile('gallery')) {
            $validated['gallery'] = $this->storeGallery($request->file('gallery'));
        }

        Product::create($validated);

        return redirect()->route('admin.products.index')->with('status', 'Product created.');
    }

    public function edit(Product $product)
    {
        $categories = Category::flattenedForSelect();

        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $this->validated($request);

        if ($validated['name'] !== $product->name) {
            $validated['slug'] = $this->uniqueSlug($validated['name'], $product->id);
        }

        if ($request->filled('colors_raw')) {
            $validated['colors'] = $this->parseColors($request->input('colors_raw'));
        }

        if ($request->hasFile('image')) {
            $validated['image'] = $this->storeImage($request->file('image'));
        }
        if ($request->hasFile('gallery')) {
            $validated['gallery'] = $this->storeGallery($request->file('gallery'));
        }

        $product->update($validated);

        return redirect()->route('admin.products.index')->with('status', 'Product updated.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return back()->with('status', 'Product deleted.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'price' => 'required|integer|min:0',
            'was_price' => 'nullable|integer|min:0',
            'badge' => 'nullable|string|max:30',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|max:4096',
            'gallery.*' => 'nullable|image|max:4096',
        ]);
    }

    private function uniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $base = Str::slug($name);
        $slug = $base;
        $i = 1;

        while (Product::where('slug', $slug)->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $slug = $base.'-'.$i++;
        }

        return $slug;
    }

    private function storeImage($file): string
    {
        return Storage::url($file->store('products', 'public'));
    }

    private function storeGallery($files): array
    {
        return collect($files)->map(fn ($file) => Storage::url($file->store('products', 'public')))->all();
    }

    private function parseColors(?string $raw): ?array
    {
        if (! $raw) {
            return null;
        }

        $colors = collect(explode("\n", $raw))
            ->map(fn ($line) => trim($line))
            ->filter()
            ->map(function ($line) {
                [$name, $hex] = array_pad(explode(':', $line, 2), 2, null);
                return ['name' => trim($name), 'hex' => trim($hex ?? '#000000')];
            })
            ->values()
            ->all();

        return $colors ?: null;
    }
}