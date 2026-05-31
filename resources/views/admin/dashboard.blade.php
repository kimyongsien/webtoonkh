<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between w-full">
            <h2 class="font-bold text-xl text-gray-800 leading-tight">
                {{ __('Admin Dashboard') }}
            </h2>

            <div class="flex items-center bg-gray-100 p-1 rounded-lg border border-gray-200">
                <a href="{{ route('admin.stories.create') }}" class="px-4 py-1.5 text-sm font-semibold text-gray-700 hover:text-black hover:bg-white hover:shadow-sm rounded-md transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Add Story
                </a>
                <div class="w-px h-6 bg-gray-300 mx-1"></div>
                <a href="{{ route('admin.categories.index') }}" class="px-4 py-1.5 text-sm font-semibold text-gray-700 hover:text-black hover:bg-white hover:shadow-sm rounded-md transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                    Categories
                </a>
                <div class="w-px h-6 bg-gray-300 mx-1"></div>
                <a href="{{ route('admin.inbox.index') }}" class="px-4 py-1.5 text-sm font-semibold text-gray-700 hover:text-black hover:bg-white hover:shadow-sm rounded-md transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    Inbox
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-500 text-sm font-medium uppercase">Total Stories</div>
                    <div class="text-3xl font-bold">{{ number_format($stats['total_stories']) }}</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-500 text-sm font-medium uppercase">Total Categories</div>
                    <div class="text-3xl font-bold">{{ number_format($stats['total_categories']) }}</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-500 text-sm font-medium uppercase">Total Users</div>
                    <div class="text-3xl font-bold">{{ number_format($stats['total_users']) }}</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-500 text-sm font-medium uppercase">Total Views</div>
                    <div class="text-3xl font-bold">{{ number_format($stats['total_views']) }}</div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                <div class="lg:col-span-7 space-y-6">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-bold mb-6">Views by Category</h3>

                        @if($categoryViews->count() > 0)
                            @php
                                $chartColors = ['#5eead4', '#2f93ee', '#f8b84a', '#f43f6c', '#7c5ce6', '#22c55e', '#f97316'];
                                $totalCategoryViews = max($categoryViews->sum('views'), 1);
                                $currentStop = 0;
                                $chartStops = [];

                                foreach ($categoryViews as $index => $categoryView) {
                                    $color = $chartColors[$index % count($chartColors)];
                                    $nextStop = $currentStop + (($categoryView['views'] / $totalCategoryViews) * 100);
                                    $chartStops[] = "{$color} {$currentStop}% {$nextStop}%";
                                    $currentStop = $nextStop;
                                }
                            @endphp

                            <div class="grid grid-cols-1 md:grid-cols-[220px_1fr] items-center gap-8 min-h-[240px]">
                                <div class="space-y-3">
                                    @foreach($categoryViews as $index => $categoryView)
                                        <div class="flex items-center gap-3 text-sm text-gray-700">
                                            <span class="h-3 w-3 rounded-full shrink-0" style="background-color: {{ $chartColors[$index % count($chartColors)] }}"></span>
                                            <span class="truncate">{{ $categoryView['name'] }}</span>
                                            <span class="ml-auto text-xs text-gray-400">{{ number_format($categoryView['views']) }}</span>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="flex justify-center">
                                    <div class="relative h-56 w-56 rounded-full" style="background: conic-gradient({{ implode(', ', $chartStops) }});">
                                        <div class="absolute inset-12 rounded-full bg-white flex flex-col items-center justify-center text-center">
                                            <div class="text-2xl font-bold text-gray-900">{{ number_format($totalCategoryViews) }}</div>
                                            <div class="text-xs font-semibold uppercase text-gray-400">views</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="min-h-[240px] rounded-2xl border-2 border-dashed border-gray-200 flex items-center justify-center text-sm text-gray-500">
                                No category views yet.
                            </div>
                        @endif
                    </div>

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-bold mb-4">Recent Stories</h3>
                        @if($recentStories->count() > 0)
                            <div class="space-y-4">
                                @foreach($recentStories as $story)
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-16 bg-gray-200 shrink-0 overflow-hidden rounded">
                                            @if($story->cover_path)
                                                <img src="{{ $story->cover_url }}" class="w-full h-full object-cover" alt="{{ $story->title }}">
                                            @endif
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="font-medium truncate">{{ $story->title }}</div>
                                            <div class="text-xs text-gray-500">{{ $story->created_at->diffForHumans() }}</div>
                                        </div>
                                        <a href="{{ route('admin.stories.edit', $story) }}" class="text-blue-600 text-sm hover:underline">Edit</a>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500">No stories yet.</p>
                        @endif
                        <div class="mt-4 text-right">
                            <a href="{{ route('admin.stories.index') }}" class="text-sm text-blue-600 hover:underline">View All Stories &rarr;</a>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-5 space-y-6">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-bold mb-4">Most Popular Stories</h3>
                        @if($popularStories->count() > 0)
                            <div class="space-y-4">
                                @foreach($popularStories as $story)
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-16 bg-gray-200 shrink-0 overflow-hidden rounded">
                                            @if($story->cover_path)
                                                <img src="{{ $story->cover_url }}" class="w-full h-full object-cover" alt="{{ $story->title }}">
                                            @endif
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="font-medium truncate">{{ $story->title }}</div>
                                            <div class="text-xs text-gray-500">{{ number_format($story->views) }} views</div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500">No views yet.</p>
                        @endif
                    </div>

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-bold">Story comments</h3>
                            <a href="{{ route('admin.feedback.index') }}" class="text-sm font-semibold text-gray-900 hover:text-blue-600 transition-colors">View More&gt;</a>
                        </div>

                        @if($latestComments->count() > 0)
                            <div class="space-y-4">
                                @foreach($latestComments as $comment)
                                    <div>
                                        @if($comment->story)
                                            <div class="flex items-center gap-3 mb-2 text-xs text-gray-500">
                                                <div class="w-8 h-10 rounded bg-gray-200 overflow-hidden shrink-0">
                                                    @if($comment->story->cover_path)
                                                        <img src="{{ $comment->story->cover_url }}" class="w-full h-full object-cover" alt="{{ $comment->story->title }}">
                                                    @endif
                                                </div>
                                                <div class="min-w-0">
                                                    <div class="font-semibold text-gray-900 truncate">{{ $comment->story->title }}</div>
                                                    <div>{{ $comment->story->category->name ?? 'Uncategorized' }}</div>
                                                </div>
                                            </div>
                                        @endif

                                        <div class="rounded-2xl border border-gray-200 bg-white px-4 py-3 shadow-[0_4px_14px_rgba(0,0,0,0.12)]">
                                            <div class="flex items-center gap-2 mb-2">
                                                <div class="h-8 w-8 rounded-full bg-pink-500 text-white flex items-center justify-center text-xs font-bold shadow">
                                                    {{ strtoupper(substr($comment->user->name ?? 'A', 0, 2)) }}
                                                </div>
                                                <div class="font-bold text-gray-900 text-sm truncate">{{ $comment->user->name ?? 'Anonymous' }}</div>
                                                <span class="text-gray-400 text-xs">&middot;</span>
                                                <div class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</div>
                                            </div>
                                            <p class="text-sm text-gray-900 line-clamp-2">{{ $comment->message }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="border-2 border-dashed border-cyan-300 rounded-lg p-6 text-center text-sm text-gray-500">
                                No story comments yet.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
