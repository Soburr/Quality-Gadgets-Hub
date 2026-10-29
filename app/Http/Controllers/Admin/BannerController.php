<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::orderBy('sort_order')->get();

        return view('admin.banners.index', compact('banners'));
    }

    public function create()
    {
        return view('admin.banners.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validated($request, imageRequired: true);
        $validated['image'] = ImageUploadService::store($request->file('image'), 'banners', 1600);

        Banner::create($validated);

        return redirect()->route('admin.banners.index')->with('status', 'Banner created.');
    }

    public function edit(Banner $banner)
    {
        return view('admin.banners.edit', compact('banner'));
    }

    public function update(Request $request, Banner $banner)
    {
        $validated = $this->validated($request, imageRequired: false);

        if ($request->hasFile('image')) {
            $validated['image'] = ImageUploadService::store($request->file('image'), 'banners', 1600);
        } else {
            unset($validated['image']);
        }

        $banner->update($validated);

        return redirect()->route('admin.banners.index')->with('status', 'Banner updated.');
    }

    public function destroy(Banner $banner)
    {
        $banner->delete();

        return back()->with('status', 'Banner deleted.');
    }

    private function validated(Request $request, bool $imageRequired): array
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:120',
            'subtitle' => 'nullable|string|max:200',
            'button_text' => 'nullable|string|max:40',
            'link_url' => ['nullable', 'string', 'max:500', 'regex:/^(\/|https?:\/\/)/'],
            'image' => [$imageRequired ? 'required' : 'nullable', 'image', 'mimes:jpeg,png,jpg,webp,gif', 'max:8192'],
            'sort_order' => 'nullable|integer|min:0',
        ], [
            'link_url.regex' => 'The link must start with / (for a page on this site) or http(s)://.',
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        return $validated;
    }
}