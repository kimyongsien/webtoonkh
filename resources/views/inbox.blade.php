<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100">
                
                <!-- Header -->
                <div class="bg-primary-600 px-8 py-6 text-white">
                    <h2 class="font-heading font-bold text-2xl">Inbox to Admin</h2>
                    <p class="text-primary-100 mt-1">Submit your story requests or report issues directly to us.</p>
                </div>

                <!-- Form -->
                <div class="p-8">
                    @if (session('success'))
                        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center gap-2">
                             <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                             {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('inbox.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-bold text-gray-700 mb-1">Your Name</label>
                            <input type="text" name="name" id="name" 
                                   value="{{ auth()->check() ? auth()->user()->name : old('name') }}"
                                   class="w-full border-gray-300 rounded-lg shadow-sm focus:border-primary-500 focus:ring-primary-500 transition-colors" required>
                            @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <!-- Birthday -->
                        <div>
                            <label for="birthday" class="block text-sm font-bold text-gray-700 mb-1">Birthday</label>
                            <input type="date" name="birthday" id="birthday" 
                                   value="{{ old('birthday') }}"
                                   class="w-full border-gray-300 rounded-lg shadow-sm focus:border-primary-500 focus:ring-primary-500 transition-colors" required>
                             @error('birthday') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <!-- Story Request -->
                        <div>
                            <label for="story_request" class="block text-sm font-bold text-gray-700 mb-1">Story Request (Optional)</label>
                            <input type="text" name="story_request" id="story_request" 
                                   value="{{ old('story_request') }}"
                                   placeholder="e.g. One Piece, Solo Leveling..."
                                   class="w-full border-gray-300 rounded-lg shadow-sm focus:border-primary-500 focus:ring-primary-500 transition-colors">
                             <p class="text-xs text-gray-500 mt-1">If you are requesting a specific webtoon, let us know here.</p>
                        </div>

                        <!-- Message -->
                        <div>
                            <label for="message" class="block text-sm font-bold text-gray-700 mb-1">Description / Message</label>
                            <textarea name="message" id="message" rows="5" 
                                      class="w-full border-gray-300 rounded-lg shadow-sm focus:border-primary-500 focus:ring-primary-500 transition-colors" 
                                      placeholder="Tell us more about your request or feedback..." required>{{ old('message') }}</textarea>
                             @error('message') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <!-- Submit Button -->
                         <button type="submit" class="w-full bg-gray-900 text-white font-bold py-3 rounded-xl hover:bg-gray-800 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                            Send Message
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
