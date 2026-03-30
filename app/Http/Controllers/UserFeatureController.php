<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\Story;
use App\Models\UserList;
use Illuminate\Http\Request;

class UserFeatureController extends Controller
{
    public function toggleList(Request $request, Story $story)
    {
        $request->validate(['type' => 'required|in:bookmark,read_later,liked']);
        $type = $request->type;

        $user = auth()->user();
        $exists = UserList::where('user_id', $user->id)
            ->where('story_id', $story->id)
            ->where('type', $type)
            ->exists();

        if ($exists) {
            UserList::where('user_id', $user->id)
                ->where('story_id', $story->id)
                ->where('type', $type)
                ->delete();
            $message = 'Removed from ' . str_replace('_', ' ', $type);
        } else {
            UserList::create([
                'user_id' => $user->id,
                'story_id' => $story->id,
                'type' => $type
            ]);
            $message = 'Added to ' . str_replace('_', ' ', $type);
        }

        return back()->with('success', $message);
    }

    public function rate(Request $request, Story $story)
    {
        $request->validate(['rating' => 'required|integer|min:1|max:5']);

        $story->ratings()->updateOrCreate(
            ['user_id' => auth()->id()],
            ['rating' => $request->rating]
        );

        return back()->with('success', 'Rating saved.');
    }

    public function submitFeedback(Request $request, Story $story)
    {
        $request->validate(['message' => 'required|string|max:1000']);

        Feedback::create([
            'user_id' => auth()->id(),
            'story_id' => $story->id,
            'message' => $request->message
        ]);

        return back()->with('success', 'Feedback submitted.');
    }
}
