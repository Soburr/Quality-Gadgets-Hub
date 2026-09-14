<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\ColorSwatch;
use App\Models\Product;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;
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
        $brands = Brand::orderBy('sort_order')->get();
        $savedColors = ColorSwatch::orderBy('name')->get();

        return view('admin.products.create', compact('categories', 'brands', 'savedColors'));
    }

    public function store(Request $request)
    {
        $validated = $this->validated($request);

        $validated['slug'] = $this->uniqueSlug($validated['name']);
        $validated['colors'] = $this->processColorVariants($request);
        $this->rememberColors($validated['colors']);

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
        $brands = Brand::orderBy('sort_order')->get();
        $savedColors = ColorSwatch::orderBy('name')->get();

        return view('admin.products.edit', compact('product', 'categories', 'brands', 'savedColors'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $this->validated($request);

        if ($validated['name'] !== $product->name) {
            $validated['slug'] = $this->uniqueSlug($validated['name'], $product->id);
        }

        $validated['colors'] = $this->processColorVariants($request);
        $this->rememberColors($validated['colors']);

        if ($request->hasFile('image')) {
            $validated['image'] = $this->storeImage($request->file('image'));
        } elseif ($request->boolean('remove_image')) {
            $validated['image'] = null;
        }

        if ($request->hasFile('gallery')) {
            $validated['gallery'] = $this->storeGallery($request->file('gallery'));
        } else {
            $existingGallery = $product->gallery ?? [];
            $removed = json_decode($request->input('removed_gallery', '[]'), true) ?: [];
            $validated['gallery'] = array_values(array_diff($existingGallery, $removed));
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
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'description' => 'nullable|string',
            'price' => 'required|integer|min:0',
            'was_price' => 'nullable|integer|min:0',
            'badge' => 'nullable|string|max:30',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:8192',
            'gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:8192',
            'is_flash_sale' => 'nullable|boolean',
            'flash_sale_ends_at' => 'nullable|date',
            'is_featured' => 'nullable|boolean',
            'colors' => 'nullable|array',
            'colors.*.name' => 'nullable|string|max:100',
            'colors.*.hex' => 'nullable|string|max:20',
            'colors.*.price' => 'nullable|integer|min:0',
            'colors.*.image' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:8192',
            'colors.*.gallery' => 'nullable|array',
            'colors.*.gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:8192',
        ]);

        $validated['is_flash_sale'] = $request->boolean('is_flash_sale');
        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['description'] = $this->sanitizeDescription($validated['description'] ?? null);

        return $validated;
    }

    private function sanitizeDescription(?string $raw): ?string
    {
        if (! $raw) {
            return null;
        }

        $allowedTags = '<b><strong><i><em><br><p><div>';
        $clean = strip_tags($raw, $allowedTags);
        $clean = preg_replace('/\son\w+\s*=\s*"[^"]*"/i', '', $clean);
        $clean = preg_replace("/\son\w+\s*=\s*'[^']*'/i", '', $clean);
        $clean = preg_replace('/javascript:/i', '', $clean);

        return trim($clean) ?: null;
    }

    private function rememberColors(?array $colors): void
    {
        foreach ($colors ?? [] as $color) {
            if (! empty($color['hex'])) {
                ColorSwatch::updateOrCreate(
                    ['hex' => $color['hex']],
                    ['name' => $color['name'] ?: $color['hex']]
                );
            }
        }
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
        return ImageUploadService::store($file, 'products', 1000);
    }

    private function storeGallery($files): array
    {
        return collect($files)->map(fn ($file) => ImageUploadService::store($file, 'products', 1000))->all();
    }

    private function processColorVariants(Request $request): ?array
    {
        $rows = $request->input('colors', []);

        if (empty($rows)) {
            return null;
        }

        $variants = [];

        foreach ($rows as $i => $row) {
            $name = trim($row['name'] ?? '');

            if ($name === '') {
                continue;
            }

            $hex = trim($row['hex'] ?? '#000000');
            $price = isset($row['price']) && $row['price'] !== '' ? (int) $row['price'] : null;

            $image = ($row['existing_image'] ?? '') !== '' ? $row['existing_image'] : null;

            if ($request->hasFile("colors.$i.image")) {
                $image = ImageUploadService::store($request->file("colors.$i.image"), 'products', 1000);
            } elseif (($row['remove_image'] ?? '0') === '1') {
                $image = null;
            }

            $existingGallery = json_decode($row['existing_gallery'] ?? '[]', true) ?: [];
            $removedGallery = json_decode($row['removed_gallery'] ?? '[]', true) ?: [];
            $gallery = array_values(array_diff($existingGallery, $removedGallery));

            if ($request->hasFile("colors.$i.gallery")) {
                foreach ($request->file("colors.$i.gallery") as $file) {
                    $gallery[] = ImageUploadService::store($file, 'products', 1000);
                }
            }

            $variants[] = [
                'name' => $name,
                'hex' => $hex,
                'price' => $price,
                'image' => $image,
                'gallery' => $gallery ?: null,
            ];
        }

        return $variants ?: null;
    }
}