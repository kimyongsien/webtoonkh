<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Categories
            </h2>

            <a href="{{ route('admin.categories.create') }}"
               class="px-4 py-2 bg-black text-white rounded">
                + New Category
            </a>
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
                                <th class="py-2">Name</th>
                                <th class="py-2">Slug</th>
                                <th class="py-2 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($categories as $category)
                                <tr class="border-b">
                                    <td class="py-2">{{ $category->name }}</td>
                                    <td class="py-2 text-gray-600">{{ $category->slug }}</td>
                                    <td class="py-2 text-right">
                                        <a class="text-blue-600 hover:underline"
                                           href="{{ route('admin.categories.edit', $category) }}">
                                            Edit
                                        </a>

                                        <form class="inline"
                                              action="{{ route('admin.categories.destroy', $category) }}"
                                              method="POST"
                                              onsubmit="return confirm('Delete this category?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="text-red-600 hover:underline ml-3" type="submit">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="py-4 text-gray-500" colspan="3">
                                        No categories yet. Click “New Category”.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $categories->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
