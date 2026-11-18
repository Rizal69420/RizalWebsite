<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-xl font-bold text-slate-900">Buat Akun Baru</h2>
        <p class="text-xs text-slate-500 mt-1">Daftar untuk mulai mengelola hardware dan pesanan</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                Nama Lengkap
            </label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                   placeholder="e.g. John Doe"
                   class="w-full rounded-xl border-slate-200 text-sm focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
            <x-input-error :messages="$errors->get('name')" class="mt-1" />
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                Alamat Email
            </label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                   placeholder="nama@example.com"
                   class="w-full rounded-xl border-slate-200 text-sm focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                Password
            </label>
            <input id="password" type="password" name="password" required autocomplete="new-password"
                   placeholder="Minimal 8 karakter"
                   class="w-full rounded-xl border-slate-200 text-sm focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                Konfirmasi Password
            </label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                   placeholder="Ulangi password"
                   class="w-full rounded-xl border-slate-200 text-sm focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
        </div>

        <!-- Register Submit Button -->
        <div class="pt-2">
            <button type="submit" class="w-full py-2.5 px-4 rounded-xl bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white font-bold text-sm shadow-md shadow-blue-500/20 transition flex items-center justify-center gap-2">
                <span>Daftar Sekarang</span>
                <span>&rarr;</span>
            </button>
        </div>
    </form>

    <!-- Return to Login Link -->
    <div class="mt-6 pt-6 border-t border-slate-100 text-center space-y-3">
        <p class="text-xs text-slate-500 font-medium">Sudah memiliki akun?</p>
        <a href="{{ route('login') }}" class="w-full inline-flex items-center justify-center py-2.5 px-4 rounded-xl border border-slate-300 text-slate-700 hover:bg-slate-50 font-semibold text-sm transition">
            <span>Masuk ke Akun Anda (Log In)</span>
        </a>
    </div>
</x-guest-layout>
