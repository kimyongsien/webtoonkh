<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Stories</h2>
            <a href="{{ route('admin.stories.create') }}" class="px-4 py-2 bg-black text-white rounded">+ New Story</a>
        </div>
    </x-slot>
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-left">
                        <thead>
                            <tr class="border-b">
                                <th class="py-2">Cover</th>
                                <th class="py-2">Title</th>
                                <th class="py-2">Category</th>
                                <th class="py-2">Views</th>
                                <th class="py-2 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($stories as $story)
                                <tr class="border-b align-top">
                                    <td class="py-2">
                                        @if($story->cover_path)
                                            <img src="{{ $story->cover_url }}" class="h-16 w-12 object-cover rounded" />
                                        @else
                                            <div class="h-16 w-12 bg-gray-200 rounded"></div>
                                        @endif
                                    </td>
                                    <td class="py-2">
                                        <div class="font-semibold">{{ $story->title }}</div>
                                        <div class="text-sm text-gray-600">
                                            Drive: {{ $story->drive_file_id ? 'yes' : 'no' }},
                                            YouTube: {{ $story->youtube_url ? 'yes' : 'no' }}
                                        </div>
                                    </td>
                                    <td class="py-2">{{ $story->category?->name }}</td>
                                    <td class="py-2">{{ $story->views }}</td>
                                    <td class="py-2 text-right">
                                        <a class="text-blue-600 hover:underline" href="{{ route('admin.stories.edit', $story) }}">Edit</a>

                                        <form class="inline"
                                              action="{{ route('admin.stories.destroy', $story) }}"
                                              method="POST"
                                              onsubmit="return confirm('Delete this story?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="text-red-600 hover:underline ml-3" type="submit">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="py-4 text-gray-500" colspan="5">No stories yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $stories->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
