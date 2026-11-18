<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-xl font-bold text-slate-900">Selamat Datang</h2>
        <p class="text-xs text-slate-500 mt-1">Silakan masuk ke akun Anda untuk melanjutkan</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                Email
            </label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                   placeholder="nama@example.com"
                   class="w-full rounded-xl border-slate-200 text-sm focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex items-center justify-between mb-1">
                <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                    Password
                </label>
                @if (Route::has('password.request'))
                    <a class="text-xs text-blue-600 hover:text-blue-800 font-medium transition" href="{{ route('password.request') }}">
                        Lupa password?
                    </a>
                @endif
            </div>

            <input id="password" type="password" name="password" required autocomplete="current-password"
                   placeholder="••••••••"
                   class="w-full rounded-xl border-slate-200 text-sm focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between pt-1">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded border-slate-300 text-blue-600 shadow-sm focus:ring-blue-500" name="remember">
                <span class="ms-2 text-xs text-slate-600">{{ __('Ingat saya') }}</span>
            </label>
        </div>

        <!-- Login Submit Button -->
        <div class="pt-2">
            <button type="submit" class="w-full py-2.5 px-4 rounded-xl bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white font-bold text-sm shadow-md shadow-blue-500/20 transition flex items-center justify-center gap-2">
                <span>Masuk (Log In)</span>
                <span>&rarr;</span>
            </button>
        </div>
    </form>

    <!-- Register Button for users who haven't made an account yet -->
    <div class="mt-6 pt-6 border-t border-slate-100 text-center space-y-3">
        <p class="text-xs text-slate-500 font-medium">Belum memiliki akun?</p>
        <a href="{{ route('register') }}" class="w-full inline-flex items-center justify-center py-2.5 px-4 rounded-xl border-2 border-blue-600 text-blue-600 hover:bg-blue-50 font-bold text-sm transition">
            <span>+ Daftar Akun Baru (Register)</span>
        </a>
    </div>
</x-guest-layout>
