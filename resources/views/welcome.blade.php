<x-app-layout>
    
    <!-- Hero Section (Slider) -->
    @if($featuredStories->count() > 0 && !request()->hasAny(['search', 'category']))
        <div x-data="{ 
                activeSlide: 0, 
                slides: {{ $featuredStories->count() }}, 
                interval: null,
                start() { this.interval = setInterval(() => { this.next() }, 5000) },
                stop() { clearInterval(this.interval) },
                next() { this.activeSlide = (this.activeSlide + 1) % this.slides },
                prev() { this.activeSlide = (this.activeSlide - 1 + this.slides) % this.slides }
             }" 
             x-init="start()" 
             @mouseenter="stop()" 
             @mouseleave="start()"
             class="relative bg-black/40 backdrop-blur-md h-[500px] overflow-hidden group">
            
            <!-- Slides -->
            @foreach($featuredStories as $index => $story)
                <div x-show="activeSlide === {{ $index }}" 
                     x-transition:enter="transition ease-out duration-700"
                     x-transition:enter-start="opacity-0 scale-105"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-500"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-95"
                     class="absolute inset-0 w-full h-full">
                    
                    <!-- Background Image (Blurred) -->
                    <div class="absolute inset-0 bg-cover bg-center opacity-40 blur-sm transform scale-110" 
                         style="background-image: url('{{ $story->cover_url ?? '' }}');">
                    </div>
                    
                    <!-- Gradient Overlay -->
                    <div class="absolute inset-0 bg-gradient-to-r from-black via-black/50 to-transparent"></div>

                    <!-- Content Container -->
                    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full flex items-center">
                        <div class="flex flex-col md:flex-row items-center gap-12 w-full">
                            <!-- Story Cover (Floating Card) -->
                            <div class="hidden md:block w-56 h-80 flex-shrink-0 rounded-lg shadow-2xl overflow-hidden border-2 border-white/10 transform -rotate-3 hover:rotate-0 transition-transform duration-500 z-10">
                                @if($story->cover_path)
                                    <img src="{{ $story->cover_url }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-gray-800 flex items-center justify-center text-white">No Cover</div>
                                @endif
                            </div>

                            <!-- Text Info -->
                            <div class="flex-1 text-white z-10">
                                <span class="inline-block px-3 py-1 bg-primary-600 text-white text-xs font-bold uppercase tracking-wider rounded-full mb-4">Featured Webtoon</span>
                                <h2 class="text-5xl md:text-7xl font-heading font-extrabold mb-4 leading-tight drop-shadow-lg scale-y-110">
                                    {{ $story->title }}
                                </h2>
                                <p class="text-lg text-gray-300 line-clamp-2 max-w-2xl mb-8 font-light">
                                    {{ $story->description }}
                                </p>
                                <div class="flex flex-wrap gap-4">
                                    <a href="{{ route('stories.show', $story) }}" class="px-8 py-3 bg-green-500 hover:bg-green-400 text-black font-bold rounded-full transition-all shadow-lg hover:shadow-green-500/30 flex items-center gap-2 transform hover:-translate-y-0.5">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        Read Now
                                    </a>
                                    @auth
                                        @php
                                            $isInReadLater = auth()->user()->lists()
                                                ->where('story_id', $story->id)
                                                ->where('type', 'read_later')
                                                ->exists();
                                        @endphp
                                        <form action="{{ route('stories.toggle-list', $story) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="type" value="read_later">
                                            <button class="px-8 py-3 bg-white/10 hover:bg-white/20 backdrop-blur-sm text-white font-bold rounded-full transition-all border border-white/30 flex items-center gap-2">
                                                <span>{{ $isInReadLater ? 'OK' : '+' }}</span> {{ $isInReadLater ? 'Saved' : 'My List' }}
                                            </button>
                                        </form>
                                    @else
                                        <a href="{{ route('login') }}" class="px-8 py-3 bg-white/10 hover:bg-white/20 backdrop-blur-sm text-white font-bold rounded-full transition-all border border-white/30 flex items-center gap-2">
                                            <span>+</span> My List
                                        </a>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            <!-- Slider Controls -->
            <button @click="prev()" class="absolute left-4 top-1/2 transform -translate-y-1/2 text-white/50 hover:text-white p-2 rounded-full hover:bg-white/10 transition-all z-20">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </button>
            <button @click="next()" class="absolute right-4 top-1/2 transform -translate-y-1/2 text-white/50 hover:text-white p-2 rounded-full hover:bg-white/10 transition-all z-20">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </button>

            <!-- Indicators -->
            <div class="absolute bottom-6 left-1/2 transform -translate-x-1/2 flex space-x-3 z-20">
                @foreach($featuredStories as $index => $story)
                    <button @click="activeSlide = {{ $index }}" 
                            :class="{'w-8 bg-green-500': activeSlide === {{ $index }}, 'w-2 bg-white/50': activeSlide !== {{ $index }}}"
                            class="h-2 rounded-full transition-all duration-300"></button>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Main Content Section (Grid + Sidebar) -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="flex flex-col lg:flex-row gap-12">
            
            <!-- Left Column: Latest Updates (Grid) -->
            <div class="lg:w-3/4">
                <!-- Filters & Search Header -->
                <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4 border-b border-gray-100 pb-4">
                    <h2 class="text-2xl font-heading font-bold text-white drop-shadow-[0_2px_2px_rgba(0,0,0,0.8)] flex items-center gap-2">
                        <span class="w-2 h-8 bg-primary-500 rounded-full shadow-lg"></span>
                        {{ request()->has('search') ? 'Search Results' : (request()->has('category') ? $categories->where('slug', request('category'))->first()->name : 'Latest Updates') }}
                    </h2>
                </div>

                <!-- Story Grid -->
                @if($stories->count() > 0)
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-y-8 gap-x-6">
                        @foreach ($stories as $story)
                            <a href="{{ route('stories.show', $story) }}" class="group block">
                                <div class="relative aspect-[2/3] rounded-lg overflow-hidden bg-gray-100 mb-3 shadow-sm hover:shadow-md transition-all">
                                    @if($story->cover_path)
                                        <img src="{{ $story->cover_url }}" alt="{{ $story->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                    @else
                                        <div class="flex items-center justify-center h-full text-gray-400">
                                            <svg class="w-12 h-12 opacity-20" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path></svg>
                                        </div>
                                    @endif
                                    

                                </div>

                                <div>
                                    <p class="text-[11px] text-gray-900 drop-shadow-[0_1px_1px_rgba(255,255,255,0.8)] uppercase font-bold tracking-wider mb-0.5">{{ $story->category->name }}</p>
                                    <h3 class="text-[15px] font-bold text-white drop-shadow-md group-hover:text-primary-300 transition-colors line-clamp-1 leading-snug">{{ $story->title }}</h3>
                                    <div class="flex items-center gap-3 mt-1.5 text-xs text-black drop-shadow-[0_1px_1px_rgba(255,255,255,0.8)]">
                                        <span class="flex items-center gap-1">
                                             <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                            {{ number_format($story->views) }}
                                        </span>
                                        <span class="flex items-center gap-1 text-yellow-500 drop-shadow-[0_1px_1px_rgba(0,0,0,0.8)]">
                                            ★ {{ $story->average_rating ?? 'N/A' }}
                                        </span>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>

                    <div class="mt-12">
                         {{ $stories->links() }}
                    </div>
                @else
                    <div class="flex flex-col items-center justify-center py-20 text-gray-500">
                        <p class="text-lg">No webtoons found.</p>
                    </div>
                @endif
            </div>

            <!-- Right Column: Hottest (Sidebar) -->
            <div class="lg:w-1/4">
                @if($hottestStories->count() > 0 && !request()->hasAny(['search', 'category']))
                    <div class="sticky top-32">
                        <div class="flex justify-between items-baseline mb-6 border-b border-gray-100 pb-2">
                            <h3 class="text-xl font-heading font-bold text-white drop-shadow-[0_2px_2px_rgba(0,0,0,0.8)]">Hottest</h3>

                        </div>
                        
                        <div class="flex flex-col gap-5">
                            @foreach($hottestStories as $index => $story)
                                <a href="{{ route('stories.show', $story) }}" class="flex items-center gap-4 group">
                                    <div class="relative w-20 h-28 flex-shrink-0 rounded-lg overflow-hidden shadow-sm bg-gray-200">
                                        @if($story->cover_path)
                                            <img src="{{ $story->cover_url }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                        @endif
                                        
                                        <!-- Ranking Number -->
                                        <div class="absolute bottom-0 right-0 bg-black text-white font-bold text-xl px-2.5 py-0.5 rounded-tl-lg">
                                            {{ $index + 1 }}
                                        </div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h4 class="font-bold text-white drop-shadow-md group-hover:text-primary-300 transition-colors truncate text-sm">{{ $story->title }}</h4>
                                        <p class="text-xs text-gray-900 drop-shadow-[0_1px_1px_rgba(255,255,255,0.8)] mb-1">{{ $story->category->name }}</p>
                                        <div class="flex items-center gap-2 text-xs text-black drop-shadow-[0_1px_1px_rgba(255,255,255,0.8)]">
                                            <span class="flex items-center gap-1">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                                {{ number_format($story->views) }}
                                            </span>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
