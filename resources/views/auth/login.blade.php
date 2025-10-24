<x-guest-layout>
    <div class="mb-8">
        <div class="flex justify-center">
            <div class="w-16 h-16 bg-gradient-to-r from-green-500 to-blue-500 rounded-full flex items-center justify-center">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            </div>
        </div>
        <h2 class="mt-6 text-center text-3xl font-bold text-gray-900">
            Dobrodošli nazad
        </h2>
        <p class="mt-2 text-center text-sm text-gray-600">
            Prijavite se na svoj nalog da nastavite
        </p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email adresa')" />
            <div class="mt-1 relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                    </svg>
                </div>
                <x-text-input id="email" class="pl-10 block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="vas@email.com" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Lozinka')" />
            <div class="mt-1 relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>
                <x-text-input id="password" class="pl-10 block mt-1 w-full" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <input id="remember_me" type="checkbox" class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded" name="remember">
                <label for="remember_me" class="ml-2 block text-sm text-gray-700">
                    {{ __('Zapamti me') }}
                </label>
            </div>

            @if (Route::has('password.request'))
                <a class="text-sm font-medium text-green-600 hover:text-green-500 transition-colors" href="{{ route('password.request') }}">
                    {{ __('Zaboravili ste lozinku?') }}
                </a>
            @endif
        </div>

        <!-- Submit Button -->
        <div>
            <x-primary-button class="w-full justify-center py-3 text-base font-semibold">
                {{ __('Prijavi se') }}
            </x-primary-button>
        </div>

        <!-- Register Link -->
        <div class="text-center">
            <p class="text-sm text-gray-600">
                Nemate nalog?
                <a href="{{ route('register') }}" class="font-medium text-green-600 hover:text-green-500 transition-colors ml-1">
                    Registrujte se
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
