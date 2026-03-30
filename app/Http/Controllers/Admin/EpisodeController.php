<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Episode;
use App\Models\Story;

class EpisodeController extends Controller
{
    public function create(Story $story)
    {
        return view('admin.episodes.create', compact('story'));
    }

    public function store(Request $request, Story $story)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'episode_number' => 'required|integer|min:1',
            'drive_file_id' => 'nullable|string|max:255',
            'youtube_url' => 'nullable|url|max:255',
        ]);

        $data['drive_file_id'] = $this->extractDriveId($data['drive_file_id'] ?? null);

        $story->episodes()->create($data);

        return redirect()->route('admin.stories.edit', $story)->with('success', 'Episode added successfully.');
    }

    public function edit(Story $story, Episode $episode)
    {
        return view('admin.episodes.edit', compact('story', 'episode'));
    }

    public function update(Request $request, Story $story, Episode $episode)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'episode_number' => 'required|integer|min:1',
            'drive_file_id' => 'nullable|string|max:255',
            'youtube_url' => 'nullable|url|max:255',
        ]);

        $data['drive_file_id'] = $this->extractDriveId($data['drive_file_id'] ?? null);

        $episode->update($data);

        return redirect()->route('admin.stories.edit', $story)->with('success', 'Episode updated successfully.');
    }

    public function destroy(Story $story, Episode $episode)
    {
        $episode->delete();
        return redirect()->route('admin.stories.edit', $story)->with('success', 'Episode deleted.');
    }

    private function extractDriveId($input)
    {
        if (empty($input)) return null;
        if (strpos($input, 'drive.google.com') !== false) {
            if (preg_match('/\/d\/([a-zA-Z0-9_-]+)/', $input, $matches)) return $matches[1];
            if (preg_match('/id=([a-zA-Z0-9_-]+)/', $input, $matches)) return $matches[1];
        }
        return $input;
    }
}
