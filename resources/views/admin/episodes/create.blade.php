<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Add Episode to: {{ $story->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                @if ($errors->any())
                    <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.stories.episodes.store', $story) }}">
                    @csrf

                    <div class="grid gap-4">
                        <div>
                            <label class="block font-medium text-sm text-gray-700">Episode Number</label>
                            <input type="number" name="episode_number" value="{{ old('episode_number', $story->episodes()->max('episode_number') + 1) }}" class="mt-1 w-full border rounded px-3 py-2" required min="1" />
                            <p class="text-xs text-gray-500 mt-1">Used for sorting. Suggested: next available number.</p>
                        </div>

                        <div>
                            <label class="block font-medium text-sm text-gray-700">Title</label>
                            <input name="title" value="{{ old('title') }}" placeholder="e.g. Chapter 1" class="mt-1 w-full border rounded px-3 py-2" required />
                        </div>

                        <div>
                            <label class="block font-medium text-sm text-gray-700">Google Drive File ID</label>
                            <input name="drive_file_id" value="{{ old('drive_file_id') }}" class="mt-1 w-full border rounded px-3 py-2" />
                            <p class="text-xs text-gray-500 mt-1">Paste full Drive link or just the ID for the reading PDF.</p>
                        </div>

                        <div>
                            <label class="block font-medium text-sm text-gray-700">YouTube URL (optional)</label>
                            <input name="youtube_url" value="{{ old('youtube_url') }}" class="mt-1 w-full border rounded px-3 py-2" />
                            <p class="text-xs text-gray-500 mt-1">If this is a video episode, paste the Youtube link.</p>
                        </div>
                    </div>

                    <div class="mt-6 flex gap-3">
                        <button class="px-4 py-2 bg-black text-white rounded font-medium" type="submit">Save Episode</button>
                        <a href="{{ route('admin.stories.edit', $story) }}" class="px-4 py-2 border rounded font-medium text-gray-700 hover:bg-gray-50">Back to Story</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
