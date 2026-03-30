<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Episode: {{ $episode->title }}
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

                <form method="POST" action="{{ route('admin.stories.episodes.update', [$story, $episode]) }}">
                    @csrf
                    @method('PUT')

                    <div class="grid gap-4">
                        <div>
                            <label class="block font-medium text-sm text-gray-700">Episode Number</label>
                            <input type="number" name="episode_number" value="{{ old('episode_number', $episode->episode_number) }}" class="mt-1 w-full border rounded px-3 py-2" required min="1" />
                        </div>

                        <div>
                            <label class="block font-medium text-sm text-gray-700">Title</label>
                            <input name="title" value="{{ old('title', $episode->title) }}" class="mt-1 w-full border rounded px-3 py-2" required />
                        </div>

                        <div>
                            <label class="block font-medium text-sm text-gray-700">Google Drive File ID</label>
                            <input name="drive_file_id" value="{{ old('drive_file_id', $episode->drive_file_id) }}" class="mt-1 w-full border rounded px-3 py-2" />
                        </div>

                        <div>
                            <label class="block font-medium text-sm text-gray-700">YouTube URL (optional)</label>
                            <input name="youtube_url" value="{{ old('youtube_url', $episode->youtube_url) }}" class="mt-1 w-full border rounded px-3 py-2" />
                        </div>
                    </div>

                    <div class="mt-6 flex gap-3">
                        <button class="px-4 py-2 bg-black text-white rounded font-medium" type="submit">Update Episode</button>
                        <a href="{{ route('admin.stories.edit', $story) }}" class="px-4 py-2 border rounded font-medium text-gray-700 hover:bg-gray-50">Back to Story</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
