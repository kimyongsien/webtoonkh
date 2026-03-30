<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Create Story</h2>
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

                <form method="POST" action="{{ route('admin.stories.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="grid gap-4">
                        <div>
                            <label class="block font-medium text-sm text-gray-700">Title</label>
                            <input name="title" value="{{ old('title') }}" class="mt-1 w-full border rounded px-3 py-2" required />
                        </div>

                        <div>
                            <label class="block font-medium text-sm text-gray-700">Category</label>
                            <select name="category_id" class="mt-1 w-full border rounded px-3 py-2" required>
                                <option value="">-- select --</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" @selected(old('category_id') == $cat->id)>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block font-medium text-sm text-gray-700">Description</label>
                            <textarea name="description" rows="4" class="mt-1 w-full border rounded px-3 py-2">{{ old('description') }}</textarea>
                        </div>

                        <div>
                            <label class="block font-medium text-sm text-gray-700">Cover (image)</label>
                            <input type="file" name="cover" class="mt-1 w-full" accept="image/*" />
                        </div>

                        <div>
                            <label class="block font-medium text-sm text-gray-700">Trailer YouTube URL (optional)</label>
                            <input name="youtube_url" value="{{ old('youtube_url') }}" class="mt-1 w-full border rounded px-3 py-2" placeholder="https://youtube.com/watch?v=..." />
                            <p class="text-xs text-gray-500 mt-1">If there's a trailer for the story, put the YouTube URL here.</p>
                        </div>
                    </div>

                    <div class="mt-6 flex gap-3">
                        <button class="px-4 py-2 bg-black text-white rounded" type="submit">Save</button>
                        <a href="{{ route('admin.stories.index') }}" class="px-4 py-2 border rounded">Cancel</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
