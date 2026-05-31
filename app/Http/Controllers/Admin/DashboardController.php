<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Feedback;
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

        $categoryViews = Category::withSum('stories', 'views')
            ->get()
            ->map(function (Category $category) {
                return [
                    'name' => $category->name,
                    'views' => (int) ($category->stories_sum_views ?? 0),
                ];
            })
            ->filter(fn (array $category) => $category['views'] > 0)
            ->sortByDesc('views')
            ->values();

        $latestComments = Feedback::with(['user', 'story.category'])
            ->whereNotNull('story_id')
            ->latest()
            ->take(2)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentStories', 'popularStories', 'categoryViews', 'latestComments'));
    }
}
