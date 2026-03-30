<?php

namespace App\Http\Controllers;

use App\Models\InboxMessage;
use Illuminate\Http\Request;

class InboxController extends Controller
{
    public function create()
    {
        return view('inbox');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'birthday' => 'required|date',
            'story_request' => 'nullable|string|max:255',
            'message' => 'required|string',
        ]);

        if (auth()->check()) {
            $validated['user_id'] = auth()->id();
        }

        InboxMessage::create($validated);

        return back()->with('success', 'Your request has been sent to the admin!');
    }
}
