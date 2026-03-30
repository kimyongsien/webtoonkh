<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Story;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_stories' => Story::count(),
            'total_categories' => Category::count(),
            'total_users' => User::count(), // Including admins
            'total_views' => Story::sum('views'),
        ];

        $recentStories = Story::with('category')
            ->latest()
            ->take(5)
            ->get();

        $popularStories = Story::orderByDesc('views')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentStories', 'popularStories'));
    }
}
