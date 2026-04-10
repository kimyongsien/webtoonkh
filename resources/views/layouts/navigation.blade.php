<div class="sticky top-0 z-50">
    <!-- Top White Bar -->
    <nav x-data="{ open: false }" class="bg-white border-b border-gray-100 relative z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <!-- Left: Hamburger & Logo -->
                <div class="flex items-center gap-4">
                    <!-- Person Setting Icon -->
                    <button @click="open = ! open" class="p-2 rounded-md text-gray-800 hover:bg-gray-100 transition-colors">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <circle cx="19" cy="11" r="3"></circle>
                            <path d="M19 16v-2"></path>
                            <path d="M19 8v-2"></path>
                            <path d="M22.03 12.52l-1.6-.92"></path>
                            <path d="M17.57 9.94l-1.6-.92"></path>
                            <path d="M22.03 9.48l-1.6.92"></path>
                            <path d="M17.57 12.06l-1.6.92"></path>
                        </svg>
                    </button>

                    <!-- Logo -->
                    <a href="{{ route('home') }}" class="flex items-center gap-2">
                        @if(file_exists(public_path('images/logo.png')))
                            <img src="{{ asset('images/logo.png') }}" class="h-10 w-auto rounded-lg">
                        @else
                           <div class="h-10 w-10 bg-pink-100 rounded-lg flex items-center justify-center text-pink-500">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                           </div>
                        @endif
                        <span class="font-heading font-medium text-2xl text-gray-600 italic">Webtoon KH</span>
                    </a>
                </div>

                <!-- Right: Login / Search -->
                <div class="flex items-center gap-4">
                    @auth
                        <!-- User Dropdown -->
                        <div x-data="{ open: false }" class="relative hidden sm:block">
                            <button @click="open = !open" class="flex items-center gap-2 focus:outline-none">
                                <div class="h-8 w-8 rounded-full bg-pink-500 flex items-center justify-center text-white font-bold text-xs shadow-md border-2 border-white ring-2 ring-pink-100">
                                    {{ substr(Auth::user()->name, 0, 2) }}
                                </div>
                                <span class="font-bold text-gray-900">{{ Auth::user()->name }}</span>
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>

                            <!-- Dropdown Menu -->
                            <div x-show="open" @click.away="open = false" 
                                 x-transition:enter="transition ease-out duration-100"
                                 x-transition:enter-start="transform opacity-0 scale-95"
                                 x-transition:enter-end="transform opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="transform opacity-100 scale-100"
                                 x-transition:leave-end="transform opacity-0 scale-95"
                                 style="display: none;"
                                 class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl border border-gray-100 py-1 z-50">
                                
                                <div class="px-4 py-3 border-b border-gray-100">
                                    <p class="text-xs text-gray-500">Signed in as</p>
                                    <p class="text-sm font-bold text-gray-900 truncate">{{ Auth::user()->name }}</p>
                                </div>

                                <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-pink-50 hover:text-pink-600 transition-colors">
                                    My Library
                                </a>

                                @if(Auth::user()->role === 'admin')
                                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-pink-50 hover:text-pink-600 transition-colors">
                                        Admin Dashboard
                                    </a>
                                @endif

                                <div class="border-t border-gray-100 my-1"></div>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 font-bold">
                                        Log Out
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="font-bold text-lg text-gray-900 hover:text-gray-600">Login</a>
                    @endauth
                    
                    <!-- Search Component -->
                    <div x-data="{ 
                            searchOpen: false, 
                            query: '', 
                            results: [], 
                            loading: false,
                            fetchResults() {
                                if (this.query.length < 2) {
                                    this.results = [];
                                    return;
                                }
                                this.loading = true;
                                fetch(`/search?q=${this.query}`)
                                    .then(res => res.json())
                                    .then(data => {
                                        this.results = data;
                                        this.loading = false;
                                    });
                            }
                        }" class="relative">
                        <button @click="searchOpen = !searchOpen; if(searchOpen) setTimeout(() => $refs.searchInput.focus(), 100)" class="text-gray-900 focus:outline-none hover:text-gray-600 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </button>

                        <!-- Search Modal Dropdown -->
                        <div x-show="searchOpen" 
                             @click.away="searchOpen = false"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 translate-y-[-10px] scale-95"
                             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                             x-transition:leave="transition ease-in duration-100"
                             x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                             x-transition:leave-end="opacity-0 translate-y-[-10px] scale-95"
                             style="display: none;"
                             class="absolute top-full right-0 mt-4 w-[90vw] sm:w-[400px] bg-white rounded-[1.8rem] shadow-[0_15px_50px_-12px_rgba(0,0,0,0.25)] p-6 z-[70] origin-top-right flex flex-col">
                             
                             <!-- Search Input -->
                             <div class="relative flex items-center mb-5">
                                 <svg class="w-5 h-5 absolute left-5 text-gray-800 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                 <input type="text" x-ref="searchInput" x-model="query" @input.debounce.300ms="fetchResults" placeholder="" class="w-full bg-[#Eceaea] text-gray-900 rounded-full pl-12 pr-5 py-3 border-none focus:ring-0 text-base font-medium transition-colors">
                                 
                                 <!-- Loading Spinner -->
                                 <svg x-show="loading" class="animate-spin w-5 h-5 absolute right-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                             </div>

                             <!-- Results Area -->
                             <div class="min-h-[100px] max-h-[300px] overflow-y-auto pr-2 custom-scrollbar flex-1">
                                 <template x-if="query.length < 2 && results.length === 0">
                                     <div class="py-6 flex flex-col items-center justify-center text-center h-[120px]">
                                         <p class="text-gray-800 text-base">No recent search</p>
                                     </div>
                                 </template>
                                 
                                 <template x-if="query.length >= 2 && results.length === 0 && !loading">
                                     <div class="py-6 flex flex-col items-center justify-center text-center h-[120px]">
                                         <p class="text-gray-800 text-base">No stories found</p>
                                     </div>
                                 </template>

                                 <template x-if="results.length > 0">
                                     <div class="space-y-3">
                                         <template x-for="story in results" :key="story.id">
                                             <a :href="`/story/${story.id}`" class="flex items-center gap-4 p-2 hover:bg-gray-50 rounded-2xl transition-colors group">
                                                 <div class="w-12 h-16 bg-gray-200 rounded-lg object-cover overflow-hidden flex-shrink-0 shadow-sm border border-gray-100">
                                                     <template x-if="story.cover_path">
                                                         <img :src="story.cover_url" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                                     </template>
                                                 </div>
                                                 <div class="flex-1 min-w-0">
                                                     <h4 class="text-base font-bold text-gray-900 line-clamp-2 leading-snug group-hover:text-pink-600 transition-colors" x-text="story.title"></h4>
                                                 </div>
                                             </a>
                                         </template>
                                     </div>
                                 </template>
                             </div>

                             <!-- Footer Actions -->
                             <div class="flex justify-end pt-3 mt-1">
                                 <button @click="searchOpen = false" type="button" class="text-[15px] font-extrabold text-black hover:text-gray-600 transition-colors px-2 py-1">Close</button>
                             </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Custom Slide-out Info Panel -->
        <div x-show="open" 
             @click.away="open = false" 
             style="display: none;" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 -translate-x-10 scale-95"
             x-transition:enter-end="opacity-100 translate-x-0 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-x-0 scale-100"
             x-transition:leave-end="opacity-0 -translate-x-10 scale-95"
             class="absolute top-[80px] left-4 sm:left-6 z-[100] w-[340px] rounded-[45px] shadow-[0_20px_50px_-10px_rgba(0,0,0,0.3)] p-6 overflow-hidden bg-white">
             
             <!-- Decorative Top Right Curve -->
             <div class="absolute top-0 right-[-10px] w-32 h-32 border-t-[1px] border-r-[1px] border-pink-200 rounded-tr-[50px] transform translate-x-4 -translate-y-4 z-0"></div>
             <!-- Decorative Bottom Left Curve -->
             <div class="absolute bottom-[-10px] left-[-10px] w-32 h-32 border-b-[1px] border-l-[1px] border-pink-200 rounded-bl-[50px] transform -translate-x-4 translate-y-4 z-0"></div>
             <!-- Decorative Bottom Line -->
             <div class="absolute bottom-6 left-1/2 transform -translate-x-1/2 w-[70%] border-b-[2px] border-pink-200 z-0"></div>

             <div class="relative z-10 pb-4">
                 <!-- Profile 1: Sine Kimyong -->
                 <div class="flex items-start gap-4 px-1 mb-6 relative z-10 pt-2">
                     <div class="flex flex-col items-center">
                         <div class="w-[65px] h-[65px] rounded-full overflow-hidden shadow-md bg-[#ff7b00] text-black flex items-center justify-center text-3xl font-sans">
                            <img src="{{ asset('images/kimyong.jpg') }}" alt="Logo">
                         </div>
                     </div>
                     
                     <div class="flex-1 flex justify-between items-start pt-1">
                         <div class="ml-1">
                             <h4 class="text-gray-900 font-medium text-[14px]">Sien Kimyong</h4>
                             <p class="text-gray-600 text-[10px] font-light">Owner</p>
                         </div>
                         <div class="mt-2 text-right">
                             <p class="text-black text-[7.5px] font-extrabold font-sans tracking-tight">Tel:<br><span class="tracking-normal text-[9.5px]">092 594 559</span></p>
                         </div>
                     </div>
                 </div>

                 <!-- Profile 2: Sok Chomroeun -->
                 <div class="flex items-start gap-4 px-1 mb-8 relative z-10 pt-2">
                     <div class="flex-1 flex justify-between items-center pt-1 pl-1">
                         <div class="mt-2 text-left">
                             <p class="text-black text-[8.5px] font-extrabold font-sans tracking-tight">Tel:<br><span class="tracking-normal text-[9.5px]">088 50 87 553</span></p>
                         </div>
                         <div class="mr-1 text-right">
                             <h4 class="text-gray-900 font-medium text-[14px]">Sok Chomroeun</h4>
                             <p class="text-gray-600 text-[10px] font-light">Admin</p>
                         </div>
                     </div>
                     
                     <div class="flex flex-col items-center">
                         <div class="w-[65px] h-[65px] rounded-full overflow-hidden shadow-md bg-[#1e88e5] text-white flex items-center justify-center text-3xl font-sans">
                            <img src="{{ asset('images/chomroeun.jpg') }}" alt="Logo">
                         </div>
                     </div>
                 </div>

                 <!-- Background Motivation -->
                 <div class="bg-[#fafafa] border-[3px] border-[#0ea5e9] w-full h-[320px] mb-5 p-3 relative z-10">
                     <p class="text-black font-extrabold text-[15px]">Background Motivation</p>
                     <p class="text-black text-[14px]">This project aims to help users learn English through reading digital story content in an engaging and easy-to-use platform. By combining storytelling with learning, users can improve their language skills in a more enjoyable and accessible way, while keeping the platform free for everyone.</p>
                 </div>
             </div>
        </div>
    </nav>

    @unless(request()->is('admin*'))
    <!-- Bottom Gradient Bar (Sub-Header) -->
    <div class="relative h-14 flex items-center shadow-md overflow-hidden bg-gray-900">
        <!-- Advanced CSS Galaxy Effect -->
        <div class="absolute inset-0 bg-gradient-to-r from-pink-300 via-purple-300 to-indigo-400 opacity-80"></div>
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/stardust.png')] opacity-30"></div> <!-- Subtle texture pattern if available or fallback -->
        
        <!-- Nebula Clouds -->
        <div class="absolute top-0 left-1/4 w-96 h-96 bg-pink-400 rounded-full mix-blend-screen filter blur-3xl opacity-30 animate-pulse"></div>
        <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-blue-400 rounded-full mix-blend-screen filter blur-3xl opacity-30 animate-pulse" style="animation-delay: 2s;"></div>
        
        <!-- Stars (CSS Radial Gradients) -->
        <div class="absolute inset-0" style="background-image: 
            radial-gradient(white 1px, transparent 1px),
            radial-gradient(white 2px, transparent 2px);
            background-size: 50px 50px, 100px 100px;
            background-position: 0 0, 25px 25px;
            opacity: 0.2;">
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full flex justify-center items-center gap-8 md:gap-12 text-white font-heading font-extrabold tracking-wide text-xs sm:text-sm md:text-base lg:text-lg uppercase drop-shadow-md overflow-x-auto overflow-y-hidden whitespace-nowrap [&::-webkit-scrollbar]:hidden [-ms-overflow-style:none] [scrollbar-width:none]">
            <a href="{{ route('home') }}" class="hover:text-yellow-200 transition-all hover:scale-105 transform">Home</a>
            <a href="{{ route('categories.index') }}" class="hover:text-yellow-200 transition-all hover:scale-105 transform">Category</a>
            
            @auth
                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="hover:text-yellow-200 transition-all hover:scale-105 transform">Admin</a>
                @endif
            @endauth

            <a href="{{ route('inbox.create') }}" class="hover:text-yellow-200 transition-all hover:scale-105 transform">Feedback</a>
            <a href="{{ route('about') }}" class="hover:text-yellow-200 transition-all hover:scale-105 transform">About</a>
        </div>
    </div>
    @endunless
</div>
