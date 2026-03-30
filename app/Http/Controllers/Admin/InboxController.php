<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InboxMessage;
use Illuminate\Http\Request;

class InboxController extends Controller
{
    public function index()
    {
        $messages = InboxMessage::latest()->paginate(20);
        return view('admin.inbox.index', compact('messages'));
    }

    public function destroy(InboxMessage $inbox_message)
    {
        $inbox_message->delete();
        return back()->with('success', 'Message deleted.');
    }
}
