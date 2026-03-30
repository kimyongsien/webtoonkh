<x-guest-layout>
    <div class="mb-8 text-center px-4">
        <h1 class="text-2xl font-bold text-gray-900 tracking-tight mb-2">Login to get more feature</h1>
        <p class="text-gray-500 text-xs font-medium">Sign up or Login in to continue</p>
    </div>

    <div class="mb-6 border-b border-gray-100"></div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div class="space-y-1">
            <x-input-label for="email" :value="__('Email')" class="text-gray-700 font-semibold text-sm ml-1" />
            <x-text-input id="email" class="block w-full px-4 py-3 bg-gray-50 border-gray-200 focus:bg-white focus:ring-pink-500 focus:border-pink-500 rounded-2xl transition-all" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="Enter your email" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="space-y-1">
            <div class="flex justify-between items-center ml-1">
                <x-input-label for="password" :value="__('Password')" class="text-gray-700 font-semibold text-sm" />
                @if (Route::has('password.request'))
                    <a class="text-xs font-semibold text-pink-500 hover:text-pink-600 transition-colors" href="{{ route('password.request') }}">
                        {{ __('Forgot password?') }}
                    </a>
                @endif
            </div>

            <x-text-input id="password" class="block w-full px-4 py-3 bg-gray-50 border-gray-200 focus:bg-white focus:ring-pink-500 focus:border-pink-500 rounded-2xl transition-all"
                            type="password"
                            name="password"
                            required autocomplete="current-password" placeholder="••••••••" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center ml-1">
            <input id="remember_me" type="checkbox" class="w-4 h-4 text-pink-500 border-gray-300 rounded focus:ring-pink-500 transition-all pointer-cursor" name="remember">
            <label for="remember_me" class="ms-3 text-sm text-gray-500 font-medium cursor-pointer">{{ __('Remember me') }}</label>
        </div>

        <div class="pt-2 space-y-4">
            <button type="submit" class="w-full py-4 bg-[#e91e63] hover:bg-[#d81b60] text-white font-bold rounded-2xl shadow-lg shadow-pink-500/30 transition-all active:scale-[0.98]">
                {{ __('Login') }}
            </button>

            <div class="relative flex items-center py-4">
                <div class="flex-grow border-t border-gray-100"></div>
                <span class="flex-shrink mx-4 text-gray-400 text-xs font-bold uppercase tracking-widest">OR</span>
                <div class="flex-grow border-t border-gray-100"></div>
            </div>

            <a href="{{ route('register') }}" class="block w-full py-4 bg-white border-2 border-gray-900 text-center text-gray-900 font-bold rounded-2xl hover:bg-gray-50 transition-all active:scale-[0.98]">
                {{ __('Sign Up') }}
            </a>
        </div>
    </form>
</x-guest-layout>
