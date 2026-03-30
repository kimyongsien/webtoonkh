<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Story</h2>
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

                <form method="POST" action="{{ route('admin.stories.update', $story) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="grid gap-4">
                        <div>
                            <label class="block font-medium text-sm text-gray-700">Title</label>
                            <input name="title" value="{{ old('title', $story->title) }}" class="mt-1 w-full border rounded px-3 py-2" required />
                        </div>

                        <div>
                            <label class="block font-medium text-sm text-gray-700">Category</label>
                            <select name="category_id" class="mt-1 w-full border rounded px-3 py-2" required>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" @selected(old('category_id', $story->category_id) == $cat->id)>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block font-medium text-sm text-gray-700">Description</label>
                            <textarea name="description" rows="4" class="mt-1 w-full border rounded px-3 py-2">{{ old('description', $story->description) }}</textarea>
                        </div>

                        <div>
                            <label class="block font-medium text-sm text-gray-700">Cover (image)</label>
                            @if($story->cover_path)
                                <img src="{{ asset('storage/'.$story->cover_path) }}" class="h-24 w-20 object-cover rounded mb-2" />
                            @endif
                            <input type="file" name="cover" class="mt-1 w-full" accept="image/*" />
                        </div>

                        <div>
                            <label class="block font-medium text-sm text-gray-700">Trailer YouTube URL (optional)</label>
                            <input name="youtube_url" value="{{ old('youtube_url', $story->youtube_url) }}" class="mt-1 w-full border rounded px-3 py-2" />
                            <p class="text-xs text-gray-500 mt-1">If there's a trailer for the story, put the YouTube URL here.</p>
                        </div>
                    </div>

                    <div class="mt-6 flex gap-3">
                        <button class="px-4 py-2 bg-black text-white rounded" type="submit">Update</button>
                        <a href="{{ route('admin.stories.index') }}" class="px-4 py-2 border rounded">Back</a>
                    </div>
                </form>

            </div>
        </div>

        <!-- Episodes Section -->
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 mt-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-bold text-gray-900">Episodes</h3>
                    <a href="{{ route('admin.stories.episodes.create', $story) }}" class="px-4 py-2 bg-black text-white rounded text-sm font-semibold hover:bg-gray-800 transition">
                        + Add Episode
                    </a>
                </div>

                @if($story->episodes && $story->episodes->count() > 0)
                    <div class="border rounded-lg overflow-hidden">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50 border-b">
                                    <th class="p-3 text-sm font-semibold text-gray-600 w-16">#</th>
                                    <th class="p-3 text-sm font-semibold text-gray-600">Title</th>
                                    <th class="p-3 text-sm font-semibold text-gray-600 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($story->episodes as $ep)
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="p-3 text-gray-800">{{ $ep->episode_number }}</td>
                                        <td class="p-3 text-gray-800 font-medium">{{ $ep->title }}</td>
                                        <td class="p-3 text-right">
                                            <div class="flex justify-end gap-2">
                                                <a href="{{ route('admin.stories.episodes.edit', [$story, $ep]) }}" class="text-blue-600 hover:underline text-sm font-medium">Edit</a>
                                                <form action="{{ route('admin.stories.episodes.destroy', [$story, $ep]) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:underline text-sm font-medium">Delete</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-8 text-gray-500 bg-gray-50 rounded border border-dashed">
                        No episodes added yet.
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
