<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="mb-6 flex items-center justify-between">
                <a href="{{ route('stories.show', $story) }}" class="inline-flex items-center gap-2 text-primary-600 hover:text-primary-700 font-bold bg-white px-4 py-2 rounded-lg shadow-sm border border-gray-100 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Back to {{ $story->title }}
                </a>
                <div class="text-right">
                    <h1 class="text-2xl font-bold font-heading text-gray-900">{{ $story->title }}</h1>
                    <p class="text-gray-500 font-medium">Episode {{ $episode->episode_number }}: {{ $episode->title }}</p>
                </div>
            </div>

            <!-- Main Content -->
            <div class="w-full">
                <!-- Youtube Preview -->
                @if($episode->youtube_url)
                    @php
                        // Extract embed URL logic (similar to accessor logic moved here or to Model if created)
                        $embedUrl = null;
                        if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i', $episode->youtube_url, $match)) {
                            $embedUrl = 'https://www.youtube.com/embed/' . $match[1] . '?rel=0';
                        }
                    @endphp
                    @if($embedUrl)
                        <div class="bg-black rounded-2xl overflow-hidden shadow-2xl mb-8 border border-gray-800">
                             <div class="aspect-video w-full">
                                <iframe src="{{ $embedUrl }}" class="w-full h-full border-0" allowfullscreen></iframe>
                             </div>
                        </div>
                    @endif
                @endif

                <!-- PDF Reader (Google Drive) -->
                @if($episode->drive_file_id)
                    <div class="bg-white rounded-2xl overflow-hidden shadow-xl mb-8 border border-gray-100">
                        <div class="p-4 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                            <h3 class="font-heading font-bold text-lg text-gray-800">Reading Mode</h3>
                            <a href="https://drive.google.com/file/d/{{ $episode->drive_file_id }}/view" target="_blank" class="text-xs font-semibold text-primary-600 hover:text-primary-700 flex items-center gap-1">
                                Open Externally <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                            </a>
                        </div>
                        <!-- Embed Google Drive PDF Viewer -->
                        <!-- Note: 'preview' ensures it's embeddable without UI clutter -->
                        <div class="aspect-[3/4] w-full bg-gray-100">
                            <iframe src="https://drive.google.com/file/d/{{ $episode->drive_file_id }}/preview" class="w-full h-full border-0" allow="autoplay"></iframe>
                        </div>
                    </div>
                @endif
                
                @if(!$episode->drive_file_id && !$episode->youtube_url)
                    <div class="bg-white rounded-2xl p-12 text-center shadow-sm border border-gray-200">
                        <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">No Content Available</h3>
                        <p class="text-gray-500">This episode does not have any reading material uploaded yet.</p>
                    </div>
                @endif

                <!-- Navigation between episodes -->
                <div class="mt-8 flex justify-between items-center border-t border-gray-200 pt-8">
                    @php
                        $prev = $story->episodes()->where('episode_number', '<', $episode->episode_number)->orderBy('episode_number', 'desc')->first();
                        $next = $story->episodes()->where('episode_number', '>', $episode->episode_number)->orderBy('episode_number', 'asc')->first();
                    @endphp
                    
                    @if($prev)
                        <a href="{{ route('episodes.show', [$story, $prev]) }}" class="px-6 py-3 bg-white text-gray-800 font-bold rounded-lg shadow-sm border border-gray-200 hover:bg-gray-50 transition-colors flex items-center gap-2">
                            &larr; Previous Episode
                        </a>
                    @else
                        <div></div>
                    @endif

                    @if($next)
                        <a href="{{ route('episodes.show', [$story, $next]) }}" class="px-6 py-3 bg-primary-600 text-white font-bold rounded-lg shadow w hover:bg-primary-700 transition-colors flex items-center gap-2">
                            Next Episode &rarr;
                        </a>
                    @else
                        <div></div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
