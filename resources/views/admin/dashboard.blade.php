<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between w-full">
            <h2 class="font-bold text-xl text-gray-800 leading-tight">
                {{ __('Admin Dashboard') }}
            </h2>
            
            <!-- Professional Admin Toolbar -->
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
                    <!-- Optional Badge for unread styling could go here -->
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Stats Grid -->
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

            <!-- Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Recent Stories -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-bold mb-4">Recent Stories</h3>
                    @if($recentStories->count() > 0)
                        <div class="space-y-4">
                            @foreach($recentStories as $story)
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-16 bg-gray-200 shrink-0 overflow-hidden rounded">
                                        @if($story->cover_path)
                                            <img src="{{ Storage::url($story->cover_path) }}" class="w-full h-full object-cover">
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

                <!-- Most Popular -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-bold mb-4">Most Popular Stories</h3>
                    @if($popularStories->count() > 0)
                        <div class="space-y-4">
                             @foreach($popularStories as $story)
                                <div class="flex items-center gap-4">
                                     <div class="w-12 h-16 bg-gray-200 shrink-0 overflow-hidden rounded">
                                        @if($story->cover_path)
                                            <img src="{{ Storage::url($story->cover_path) }}" class="w-full h-full object-cover">
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
            </div>

        </div>
    </div>
</x-app-layout>
