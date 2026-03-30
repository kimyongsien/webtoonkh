<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="lg:flex lg:gap-12">
                <!-- Sidebar (Info & Actions) -->
                <div class="lg:w-1/3 flex-shrink-0 mb-8 lg:mb-0">
                    <div class="sticky top-32">
                        <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
                            <!-- Cover Image -->
                            <div class="aspect-[2/3] relative group">
                                @if($story->cover_path)
                                    <img src="{{ Storage::url($story->cover_path) }}" alt="{{ $story->title }}" class="w-full h-full object-cover">
                                @else
                                     <div class="w-full h-full bg-gray-200 flex items-center justify-center text-gray-400">No Cover</div>
                                @endif
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                                <div class="absolute bottom-4 left-4">
                                     <span class="bg-primary-600 text-white text-xs font-bold px-2 py-1 rounded-full uppercase tracking-wider shadow-sm">
                                        {{ $story->category->name }}
                                     </span>
                                </div>
                            </div>

                            <!-- Title & Metadata -->
                            <div class="p-6">
                                <h1 class="text-3xl font-heading font-extrabold text-gray-900 leading-tight mb-2">{{ $story->title }}</h1>
                                <div class="flex items-center gap-4 text-sm text-gray-500 mb-6 font-medium">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        {{ number_format($story->views) }}
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                        {{ $story->average_rating ?? 'N/A' }}
                                    </span>
                                </div>
                                
                                <p class="text-gray-600 text-sm leading-relaxed mb-6">{{ $story->description }}</p>

                                <!-- User Actions -->
                                @auth
                                    <div class="grid grid-cols-2 gap-3 mb-6">
                                        <!-- Bookmark -->
                                        <form action="{{ route('stories.toggle-list', $story) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="type" value="bookmark">
                                            <button class="w-full py-2.5 rounded-lg border text-sm font-bold transition-all flex items-center justify-center gap-2 {{ auth()->user()->lists()->where('story_id', $story->id)->where('type', 'bookmark')->exists() ? 'bg-yellow-50 border-yellow-200 text-yellow-700 hover:bg-yellow-100' : 'bg-white border-gray-200 text-gray-700 hover:bg-gray-50 hover:border-gray-300' }}">
                                                <svg class="w-4 h-4" fill="{{ auth()->user()->lists()->where('story_id', $story->id)->where('type', 'bookmark')->exists() ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path></svg>
                                                {{ auth()->user()->lists()->where('story_id', $story->id)->where('type', 'bookmark')->exists() ? 'Bookmarked' : 'Bookmark' }}
                                            </button>
                                        </form>

                                        <!-- Read Later -->
                                        <form action="{{ route('stories.toggle-list', $story) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="type" value="read_later">
                                            <button class="w-full py-2.5 rounded-lg border text-sm font-bold transition-all flex items-center justify-center gap-2 {{ auth()->user()->lists()->where('story_id', $story->id)->where('type', 'read_later')->exists() ? 'bg-blue-50 border-blue-200 text-blue-700 hover:bg-blue-100' : 'bg-white border-gray-200 text-gray-700 hover:bg-gray-50 hover:border-gray-300' }}">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                {{ auth()->user()->lists()->where('story_id', $story->id)->where('type', 'read_later')->exists() ? 'Saved' : 'Read Later' }}
                                            </button>
                                        </form>
                                    </div>

                                    <!-- Rating -->
                                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-100 text-center">
                                         <span class="text-xs font-bold text-gray-400 uppercase tracking-widest block mb-2">Your Rating</span>
                                         <form action="{{ route('stories.rate', $story) }}" method="POST" class="flex justify-center gap-1 group">
                                            @csrf
                                            <input type="hidden" name="rating" id="rating-input">
                                            @foreach(range(1,5) as $r)
                                                <button type="submit" name="rating" value="{{ $r }}" class="text-2xl transition-transform hover:scale-110 focus:outline-none {{ ($story->user_rating >= $r) ? 'text-yellow-400' : 'text-gray-300 hover:text-yellow-400' }}">
                                                    ★
                                                </button>
                                            @endforeach
                                        </form>
                                    </div>
                                @else
                                    <a href="{{ route('login') }}" class="block w-full py-3 bg-primary-600 hover:bg-primary-700 text-white text-center font-bold rounded-lg shadow-md hover:shadow-lg transition-all">
                                        Log in to Interact
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="lg:w-2/3">
                    <!-- Youtube Trailer Preview -->
                    @if($story->youtube_embed_url)
                        <div class="bg-black rounded-2xl overflow-hidden shadow-2xl mb-8 border border-gray-800">
                             <div class="aspect-video w-full">
                                <iframe src="{{ $story->youtube_embed_url }}" class="w-full h-full border-0" allowfullscreen></iframe>
                             </div>
                        </div>
                    @endif

                    <!-- Episodes List -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="p-6 border-b border-gray-100 bg-white">
                            <h3 class="font-heading font-bold text-lg text-gray-800">Lists of the episode</h3>
                        </div>
                        
                        <div class="p-0">
                            @if($episodes->count() > 0)
                                <div class="p-4">
                                    <ul class="flex flex-col gap-4">
                                        @foreach($episodes as $episode)
                                            <li class="border border-gray-200 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-shadow bg-white m-1">
                                                <a href="{{ route('episodes.show', [$story, $episode]) }}" class="block hover:bg-gray-50 transition-colors group">
                                                    <div class="flex items-center justify-between px-6 py-5">
                                                        <div class="flex items-center gap-4">
                                                            @if($episode->youtube_url)
                                                                <svg class="w-6 h-6 text-red-500 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/></svg>
                                                            @else
                                                                <svg class="w-6 h-6 text-gray-400 group-hover:text-primary-600 transition-colors flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                                            @endif
                                                            <span class="text-gray-900 font-medium group-hover:text-primary-600 transition-colors text-lg">{{ $episode->title }}</span>
                                                        </div>
                                                        <div class="text-sm text-gray-500 font-medium whitespace-nowrap ml-4">
                                                            {{ $episode->created_at->format('M j, Y') }}
                                                        </div>
                                                    </div>
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                                
                                <!-- Pagination -->
                                <div class="p-4 border-t border-gray-100 flex justify-center">
                                    {{ $episodes->links() }}
                                </div>
                            @else
                                <div class="text-center py-12 text-gray-500">
                                    <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                    <p>No episodes available yet.</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Feedback Section -->
                    <div class="mt-12">
                        <h3 class="font-heading font-bold text-xl text-gray-900 mb-6 flex items-center gap-2">
                            Feedback & Comments
                        </h3>

                        @auth
                            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
                                 <form action="{{ route('stories.feedback', $story) }}" method="POST">
                                    @csrf
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Leave a comment</label>
                                    <textarea name="message" rows="3" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-primary-500 focus:ring-primary-500 transition-colors bg-gray-50 focus:bg-white" placeholder="What did you think of this chapter?" required></textarea>
                                    <div class="mt-3 text-right">
                                        <button type="submit" class="bg-gray-900 text-white px-6 py-2 rounded-lg font-bold text-sm hover:bg-gray-800 transition-colors shadow-md">Post Comment</button>
                                    </div>
                                 </form>
                            </div>
                        @else
                             <div class="bg-blue-50 rounded-xl p-6 text-center border border-blue-100">
                                <p class="text-blue-800 font-medium mb-3">Join the discussion!</p>
                                <a href="{{ route('login') }}" class="inline-block px-6 py-2 bg-white text-blue-600 font-bold rounded-lg border border-blue-200 hover:bg-blue-50 transition-colors">Log in to comment</a>
                            </div>
                        @endauth
                        
                        <!-- Comments List -->
                        <div class="space-y-6">
                            @forelse($story->feedback as $comment)
                                <div class="bg-gray-50 rounded-xl p-6 border border-gray-100 flex gap-4">
                                    <div class="flex-shrink-0">
                                        <div class="w-10 h-10 rounded-full bg-primary-100 flex items-center justify-center text-primary-700 font-bold border border-primary-200">
                                            {{ substr($comment->user->name, 0, 1) }}
                                        </div>
                                    </div>
                                    <div class="flex-grow">
                                        <div class="flex items-center justify-between mb-1">
                                            <h4 class="font-bold text-gray-900">{{ $comment->user->name }}</h4>
                                            <span class="text-xs text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
                                        </div>
                                        <p class="text-gray-600 text-sm leading-relaxed">{{ $comment->message }}</p>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-8">
                                    <p class="text-gray-400">No comments yet. Be the first to share your thoughts!</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
