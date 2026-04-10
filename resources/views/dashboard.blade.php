<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <!-- Profile Header Section -->
    <div class="bg-white border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex items-center gap-6">
                <!-- Profile Avatar -->
                <div class="h-20 w-20 rounded-full bg-pink-500 flex items-center justify-center text-white font-bold text-2xl shadow-lg border-4 border-white ring-2 ring-pink-100">
                    {{ substr(Auth::user()->name, 0, 2) }}
                </div>
                
                <!-- User Info -->
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">{{ Auth::user()->name }}</h1>
                    <p class="text-gray-500">{{ Auth::user()->email }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Bookmarks -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4">My Bookmarks</h3>
                @if(auth()->user()->lists()->where('type', 'bookmark')->exists())
                    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                        @foreach(auth()->user()->lists()->where('type', 'bookmark')->with('story')->get() as $list)
                            <a href="{{ route('stories.show', $list->story) }}" class="group">
                                <div class="aspect-[2/3] bg-gray-200 overflow-hidden rounded mb-2">
                                     @if($list->story->cover_path)
                                        <img src="{{ $list->story->cover_url }}" class="w-full h-full object-cover">
                                    @endif
                                </div>
                                <div class="text-sm font-medium truncate">{{ $list->story->title }}</div>
                            </a>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500">No bookmarks yet.</p>
                @endif
            </div>

            <!-- Read Later -->
             <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4">Read Later</h3>
                @if(auth()->user()->lists()->where('type', 'read_later')->exists())
                    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                        @foreach(auth()->user()->lists()->where('type', 'read_later')->with('story')->get() as $list)
                            <a href="{{ route('stories.show', $list->story) }}" class="group">
                                <div class="aspect-[2/3] bg-gray-200 overflow-hidden rounded mb-2">
                                     @if($list->story->cover_path)
                                        <img src="{{ $list->story->cover_url }}" class="w-full h-full object-cover">
                                    @endif
                                </div>
                                <div class="text-sm font-medium truncate">{{ $list->story->title }}</div>
                            </a>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500">List is empty.</p>
                @endif
            </div>

            <!-- History -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4">View History</h3>
                @if(auth()->user()->viewHistories()->exists())
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                         @foreach(auth()->user()->viewHistories()->with('story')->take(10)->get() as $history)
                            <a href="{{ route('stories.show', $history->story) }}" class="flex items-start gap-4 p-2 hover:bg-gray-50 rounded">
                                <div class="w-16 h-24 bg-gray-200 shrink-0 overflow-hidden rounded">
                                    @if($history->story->cover_path)
                                        <img src="{{ $history->story->cover_url }}" class="w-full h-full object-cover">
                                    @endif
                                </div>
                                <div>
                                    <div class="font-bold">{{ $history->story->title }}</div>
                                    <div class="text-xs text-gray-500">Viewed {{ $history->updated_at->diffForHumans() }}</div>
                                </div>
                            </a>
                         @endforeach
                    </div>
                @else
                     <p class="text-gray-500">No history.</p>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
