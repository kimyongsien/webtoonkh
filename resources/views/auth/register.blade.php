<x-guest-layout>
    <div class="mb-8 text-center px-4">
        <h1 class="text-2xl font-bold text-gray-900 tracking-tight mb-2">Create an account</h1>
        <p class="text-gray-500 text-xs font-medium">Join us to unlock more features</p>
    </div>

    <div class="mb-6 border-b border-gray-100"></div>

    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf

        <!-- Name -->
        <div class="space-y-1">
            <x-input-label for="name" :value="__('Name')" class="text-gray-700 font-semibold text-sm ml-1" />
            <x-text-input id="name" class="block w-full px-4 py-3 bg-gray-50 border-gray-200 focus:bg-white focus:ring-pink-500 focus:border-pink-500 rounded-2xl transition-all" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Your full name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Username -->
        <div class="mt-4 space-y-1">
            <x-input-label for="username" :value="__('Username')" class="text-gray-700 font-semibold text-sm ml-1" />
            <x-text-input id="username" class="block w-full px-4 py-3 bg-gray-50 border-gray-200 focus:bg-white focus:ring-pink-500 focus:border-pink-500 rounded-2xl transition-all" type="text" name="username" :value="old('username')" required autocomplete="username" placeholder="Choose a username" />
            <x-input-error :messages="$errors->get('username')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4 space-y-1">
            <x-input-label for="email" :value="__('Email')" class="text-gray-700 font-semibold text-sm ml-1" />
            <x-text-input id="email" class="block w-full px-4 py-3 bg-gray-50 border-gray-200 focus:bg-white focus:ring-pink-500 focus:border-pink-500 rounded-2xl transition-all" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="Enter your email" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4 space-y-1">
            <x-input-label for="password" :value="__('Password')" class="text-gray-700 font-semibold text-sm ml-1" />
            <x-text-input id="password" class="block w-full px-4 py-3 bg-gray-50 border-gray-200 focus:bg-white focus:ring-pink-500 focus:border-pink-500 rounded-2xl transition-all"
                            type="password"
                            name="password"
                            required autocomplete="new-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4 space-y-1">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-gray-700 font-semibold text-sm ml-1" />
            <x-text-input id="password_confirmation" class="block w-full px-4 py-3 bg-gray-50 border-gray-200 focus:bg-white focus:ring-pink-500 focus:border-pink-500 rounded-2xl transition-all"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="pt-2 space-y-4">
            <button type="submit" class="w-full py-4 bg-[#e91e63] hover:bg-[#d81b60] text-white font-bold rounded-2xl shadow-lg shadow-pink-500/30 transition-all active:scale-[0.98]">
                {{ __('Register') }}
            </button>

            <div class="relative flex items-center py-4">
                <div class="flex-grow border-t border-gray-100"></div>
                <span class="flex-shrink mx-4 text-gray-400 text-xs font-bold uppercase tracking-widest">OR</span>
                <div class="flex-grow border-t border-gray-100"></div>
            </div>

            <a href="{{ route('login') }}" class="block w-full py-4 bg-white border-2 border-gray-900 text-center text-gray-900 font-bold rounded-2xl hover:bg-gray-50 transition-all active:scale-[0.98]">
                {{ __('Login') }}
            </a>
        </div>
    </form>
</x-guest-layout>
