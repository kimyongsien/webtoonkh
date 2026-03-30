<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Story;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StoryController extends Controller
{
    public function index()
    {
        $stories = Story::with('category')->latest()->paginate(10);
        return view('admin.stories.index', compact('stories'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.stories.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'cover' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'youtube_url' => 'nullable|url|max:255',
        ]);

        $coverPath = null;
        if ($request->hasFile('cover') && $request->file('cover')->isValid()) {
            $coverPath = $request->file('cover')->store('covers', 'public');
        }

        Story::create([
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'category_id' => $data['category_id'],
            'cover_path' => $coverPath,
            'youtube_url' => $data['youtube_url'] ?? null,
            'views' => 0,
        ]);

        return redirect()->route('admin.stories.index')->with('success', 'Story created.');
    }

    public function edit(Story $story)
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.stories.edit', compact('story', 'categories'));
    }

    public function update(Request $request, Story $story)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'cover' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'youtube_url' => 'nullable|url|max:255',
        ]);

        if ($request->hasFile('cover') && $request->file('cover')->isValid()) {
            if ($story->cover_path) {
                Storage::disk('public')->delete($story->cover_path);
            }
            $story->cover_path = $request->file('cover')->store('covers', 'public');
        }

        $story->title = $data['title'];
        $story->description = $data['description'] ?? null;
        $story->category_id = $data['category_id'];
        $story->youtube_url = $data['youtube_url'] ?? null;
        $story->save();

        return redirect()->route('admin.stories.index')->with('success', 'Story updated.');
    }

    public function destroy(Story $story)
    {
        if ($story->cover_path) {
            Storage::disk('public')->delete($story->cover_path);
        }

        $story->delete();

        return redirect()->route('admin.stories.index')->with('success', 'Story deleted.');
    }

    /**
     * Extract the Google Drive File ID from a URL or return the ID if it's already just an ID.
     */
    private function extractDriveId($input)
    {
        if (empty($input)) {
            return null;
        }

        // If it looks like a URL, try to extract the ID
        if (strpos($input, 'drive.google.com') !== false) {
            // Match pattern /d/{ID}/
            if (preg_match('/\/d\/([a-zA-Z0-9_-]+)/', $input, $matches)) {
                return $matches[1];
            }
            // Match pattern id={ID}
            if (preg_match('/id=([a-zA-Z0-9_-]+)/', $input, $matches)) {
                return $matches[1];
            }
        }

        // Return input as is (assuming it is the ID)
        return $input;
    }
}
