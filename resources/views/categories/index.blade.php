<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 backdrop-blur-sm bg-white/5 rounded-2xl shadow-2xl">
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10">
            @foreach($categories as $category)
                <!-- Category Card -->
                <a href="{{ route('home', ['category' => $category->slug]) }}" class="block group">
                    <div class="bg-white/[0.95] backdrop-blur-sm p-6 shadow-lg hover:shadow-2xl transition-all duration-300 transform group-hover:-translate-y-1">
                        
                        <!-- Image Container -->
                        <div class="aspect-square bg-gray-200 mb-6 overflow-hidden relative shadow-inner">
                            @if($category->image_path)
                                <img src="{{ $category->image_url }}" 
                                     alt="{{ $category->name }}" 
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 ease-in-out">
                            @elseif($category->stories->isNotEmpty() && $category->stories->first()->cover_path)
                                <img src="{{ $category->stories->first()->cover_url }}" 
                                     alt="{{ $category->name }}" 
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 ease-in-out">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gray-300 text-gray-400">
                                    <!-- Placeholder -->
                                    <svg class="w-20 h-20 opacity-20" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                            @endif
                        </div>

                        <!-- Category Name -->
                        <h3 class="text-sm md:text-base font-extrabold text-gray-800 uppercase tracking-widest">{{ $category->name }}</h3>
                    </div>
                </a>
            @endforeach
        </div>

        @if($categories->isEmpty())
            <div class="flex flex-col items-center justify-center py-20 text-white bg-black/20 rounded-xl backdrop-blur-md">
                <svg class="w-16 h-16 mb-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                <p class="text-xl font-bold">No categories available.</p>
            </div>
        @endif

    </div>
</x-app-layout>
