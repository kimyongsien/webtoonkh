<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Create Category
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

                <form method="POST" action="{{ route('admin.categories.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Name</label>
                        <input
                            name="name"
                            value="{{ old('name') }}"
                            class="mt-1 w-full border rounded px-3 py-2"
                            placeholder="Action, Romance, Horror..."
                            required
                        />
                    </div>

                    <div class="mt-4">
                        <label class="block font-medium text-sm text-gray-700">Category Cover (Optional)</label>
                        <input
                            type="file"
                            name="image"
                            accept="image/*"
                            class="mt-1 w-full border rounded px-3 py-2"
                        />
                    </div>

                    <div class="mt-6 flex gap-3">
                        <button class="px-4 py-2 bg-black text-white rounded" type="submit">
                            Save
                        </button>

                        <a href="{{ route('admin.categories.index') }}"
                           class="px-4 py-2 border rounded">
                            Cancel
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
