<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Category
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
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

                <form method="POST" action="{{ route('admin.categories.update', $category) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Name</label>
                        <input
                            name="name"
                            value="{{ old('name', $category->name) }}"
                            class="mt-1 w-full border rounded px-3 py-2"
                            required
                        />
                        <p class="text-sm text-gray-500 mt-2">
                            Current slug: <span class="font-mono">{{ $category->slug }}</span>
                        </p>
                    </div>

                    <div class="mt-4">
                        <label class="block font-medium text-sm text-gray-700">Category Cover (Optional)</label>
                        
                        @if($category->image_path)
                            <div class="mb-3">
                                <img src="{{ Storage::url($category->image_path) }}" alt="{{ $category->name }}" class="w-32 h-32 object-cover rounded shadow-sm border">
                            </div>
                        @endif

                        <input
                            type="file"
                            name="image"
                            accept="image/*"
                            class="mt-1 w-full border rounded px-3 py-2"
                        />
                    </div>

                    <div class="mt-6 flex gap-3">
                        <button class="px-4 py-2 bg-black text-white rounded" type="submit">
                            Update
                        </button>

                        <a href="{{ route('admin.categories.index') }}"
                           class="px-4 py-2 border rounded">
                            Back
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
