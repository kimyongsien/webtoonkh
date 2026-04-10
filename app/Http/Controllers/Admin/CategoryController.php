<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Services\CloudinaryService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function __construct(
        private CloudinaryService $cloudinary,
    ) {
    }

    public function index()
    {
        $categories = Category::latest()->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $imagePath = null;
        $imagePublicId = null;
        if ($request->hasFile('image')) {
            $upload = $this->cloudinary->uploadImage($request->file('image'), 'webtoonkh/categories');
            $imagePath = $upload['secure_url'];
            $imagePublicId = $upload['public_id'];
        }

        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'image_path' => $imagePath,
            'image_public_id' => $imagePublicId,
        ]);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category created successfully.');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $data = [
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ];

        if ($request->hasFile('image')) {
            if ($category->image_public_id) {
                $this->cloudinary->destroyImage($category->image_public_id);
            }
            $upload = $this->cloudinary->uploadImage($request->file('image'), 'webtoonkh/categories');
            $data['image_path'] = $upload['secure_url'];
            $data['image_public_id'] = $upload['public_id'];
        }

        $category->update($data);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        if ($category->image_public_id) {
            $this->cloudinary->destroyImage($category->image_public_id);
        }

        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category deleted.');
    }
}
