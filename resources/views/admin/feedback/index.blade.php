<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Story Comments') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900">
                    <div class="flex items-center justify-between mb-8">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">Story Comments</h1>
                            <p class="text-sm text-gray-500 mt-1">Comments posted from the story detail pages.</p>
                        </div>
                        <a href="{{ route('admin.dashboard') }}" class="text-sm font-semibold text-blue-600 hover:underline">Back to Dashboard</a>
                    </div>

                    <div class="space-y-5">
                        @forelse ($feedbacks as $feedback)
                            <div class="grid grid-cols-1 md:grid-cols-[220px_1fr_auto] gap-4 items-center rounded-2xl border border-gray-100 bg-gray-50 p-4">
                                <a href="{{ $feedback->story ? route('stories.show', $feedback->story) : '#' }}" class="flex items-center gap-4 min-w-0">
                                    <div class="w-16 h-24 rounded-lg bg-gray-200 overflow-hidden shrink-0 shadow-sm">
                                        @if($feedback->story && $feedback->story->cover_path)
                                            <img src="{{ $feedback->story->cover_url }}" class="w-full h-full object-cover" alt="{{ $feedback->story->title }}">
                                        @endif
                                    </div>

                                    <div class="min-w-0">
                                        <div class="font-semibold text-gray-900 truncate">
                                            {{ $feedback->story->title ?? 'Deleted story' }}
                                        </div>
                                        <div class="inline-flex mt-2 px-2 py-0.5 rounded bg-green-200 text-green-900 text-xs font-medium">
                                            {{ $feedback->story->category->name ?? 'Uncategorized' }}
                                        </div>
                                    </div>
                                </a>

                                <div class="rounded-2xl border border-gray-200 bg-white px-5 py-4 shadow-[0_4px_14px_rgba(0,0,0,0.12)]">
                                    <div class="flex flex-wrap items-center gap-2 mb-3">
                                        <div class="h-9 w-9 rounded-full bg-pink-500 text-white flex items-center justify-center text-xs font-bold shadow">
                                            {{ strtoupper(substr($feedback->user->name ?? 'A', 0, 2)) }}
                                        </div>
                                        <div class="font-bold text-gray-900">{{ $feedback->user->name ?? 'Anonymous' }}</div>
                                        <span class="text-gray-400 text-xs">&middot;</span>
                                        <div class="text-xs text-gray-500">{{ $feedback->created_at->diffForHumans() }}</div>
                                    </div>

                                    <p class="text-gray-900 leading-relaxed">{{ $feedback->message }}</p>
                                </div>

                                <form action="{{ route('admin.feedback.destroy', $feedback) }}" method="POST" onsubmit="return confirm('Delete this comment?');" class="md:justify-self-end">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-4 py-2 rounded-lg bg-red-50 text-red-600 text-sm font-bold hover:bg-red-100 transition-colors">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        @empty
                            <div class="rounded-2xl border-2 border-dashed border-gray-200 p-12 text-center text-gray-500">
                                No story comments found.
                            </div>
                        @endforelse
                    </div>

                    <div class="mt-6">
                        {{ $feedbacks->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
